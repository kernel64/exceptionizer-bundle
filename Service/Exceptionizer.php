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
        $className = $this->getExceptionClassName($exceptionName);
        if (!$className) {
            $className = $exceptionName;
        }

        $reflector = new \ReflectionClass($className);

        /** @var \Exception $exception */
        $exception = $reflector->newInstanceArgs($args);
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
     * @return bool|string
     */
    protected function getExceptionClassName($exceptionName)
    {
        if (isset($this->parameters[$exceptionName])) {
            return $this->parameters[$exceptionName]['class'];
        }

        return false;
    }
}
