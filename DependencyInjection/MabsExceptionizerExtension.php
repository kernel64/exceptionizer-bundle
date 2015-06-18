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
        $configs = array_merge($configs,Yaml::parse(file_get_contents($file)));
        var_dump($configs);
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new Loader\XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'mabs_exceptionizer';
    }
}
