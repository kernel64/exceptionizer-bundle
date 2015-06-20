<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 10/06/2015
 */

namespace Mabs\ExceptionizerBundle\Service;


class Exceptionizer
{

    private $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param $exceptionName
     * @param array $args
     * @throws \Exception
     */
    public function cast($exceptionName, array $args = array())
    {
        $exceptionDef = $this->getExceptionDefinition($exceptionName);
        if (!$exceptionDef) {
            $className = $exceptionName;
            $exceptionArgs = $args;
        } else {
            $className = $exceptionDef['class'];
            unset($exceptionDef['class']);
            $exceptionArgs =array_merge($exceptionDef, $args);
        }

        $reflector = new \ReflectionClass($className);

        /** @var \Exception $exception */
        $exception = $reflector->newInstanceArgs($exceptionArgs);
        throw $exception;
    }

    /**
     * @param $exceptionName
     * @param callable $callback
     * @param bool $thowOthers
     * @return bool
     * @throws \Exception
     */
    public function trap($exceptionName, \Closure $callback, $thowOthers = false)
    {
        try {
            call_user_func($callback);
        } catch (\Exception $e) {
            if (get_class($e) === $exceptionName) {
                return true;
            } elseif ($thowOthers === true) {
                $this->cast($exceptionName, $e->getMessage(), $e->getCode(), $e->getPrevious());
            }
        }

        return false;
    }

    /**
     * @param $exceptionName
     * @return bool|mixed
     */
    protected function getExceptionDefinition($exceptionName)
    {
        if (isset($this->parameters['exceptions'][$exceptionName])) {
            return $this->parameters['exceptions'][$exceptionName];
        }

        return false;
    }
}
