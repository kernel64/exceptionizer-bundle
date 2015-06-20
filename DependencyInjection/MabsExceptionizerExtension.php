<?php

namespace Mabs\ExceptionizerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MabsExceptionizerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $file = __DIR__.'/../Resources/config/config.yml';
        $defaultConfig = array_merge($configs, Yaml::parse(file_get_contents($file)));
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new Loader\XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');

        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }

        $defaultExceptions = $defaultConfig['mabs_exceptionizer']['exceptions'];
        if (isset($config['exceptions'])) {
            $config['exceptions'] = array_replace_recursive($defaultExceptions, $config['exceptions']);
        }

        $container->setParameter('mabs_exceptionizer', $config);
    }

    public function getAlias()
    {
        return 'mabs_exceptionizer';
    }
}
