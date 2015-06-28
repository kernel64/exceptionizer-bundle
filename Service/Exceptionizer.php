<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 10/06/2015
 */

namespace Mabs\ExceptionizerBundle\Service;

use Mabs\ExceptionizerBundle\Exceptionizer\Common\ThrowerInterface;
use Mabs\ExceptionizerBundle\Exceptionizer\Common\CatcherInterface;

class Exceptionizer
{
    /**
     * @var mixed
     */
    private $parameters;

    /**
     * @var \Mabs\ExceptionizerBundle\Exceptionizer\Common\ThrowerInterface $thrower
     */
    private $thrower;

    /**
     * @var \Mabs\ExceptionizerBundle\Exceptionizer\Common\CatcherInterface $catcher
     */
    private $catcher;

    public function __construct(ThrowerInterface $thrower, CatcherInterface $catcher, $parameters)
    {
        $this->thrower = $thrower;
        $this->catcher = $catcher;
        $this->parameters = $parameters;
    }

    /**
     * @param string $exceptionName
     * @param array $args
     * @throws \Exception
     */
    public function throwException($exceptionName, array $args = array())
    {
        $className = $this->getExceptionClassName($exceptionName);
        $exceptionArgs = $this->getExceptionArguments($exceptionName);
        $exceptionArgs = array_merge($exceptionArgs, $args);

        $this->thrower->cast($className, $exceptionArgs);
    }

    /**
     * @param $exceptionName
     * @param callable $callback
     * @return bool
     */
    public function catchException($exceptionName, \Closure $callback)
    {
        $className = $this->getExceptionClassName($exceptionName);

        return $this->catcher->trap($className, $callback);
    }

    /**
     * @param $exceptionName
     * @return string
     */
    protected function getExceptionClassName($exceptionName)
    {
        if (isset($this->parameters['exceptions'][$exceptionName])) {
            return $this->parameters['exceptions'][$exceptionName]['class'];
        }

        return $exceptionName;
    }

    /**
     * @param $exceptionName
     * @return mixed
     */
    protected function getExceptionArguments($exceptionName)
    {
        if (isset($this->parameters['exceptions'][$exceptionName])
            && isset($this->parameters['exceptions'][$exceptionName]['arguments'])
        ) {
            return $this->parameters['exceptions'][$exceptionName]['arguments'];
        }

        return array();
    }
}
