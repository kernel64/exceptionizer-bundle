<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 21/06/2015
 */

namespace Mabs\ExceptionizerBundle\Exceptionizer;


class Thrower implements Common\ThrowerInterface
{

    /**
     * @param string $className
     * @param array $args
     * @throws \Exception
     */
    public function cast($className, array $args = array())
    {
        $reflector = new \ReflectionClass($className);
        /** @var \Exception $exception */
        $exception = $reflector->newInstanceArgs($args);
        throw $exception;
    }
}
