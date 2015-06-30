<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 21/06/2015
 */

namespace Mabs\ExceptionizerBundle\Exceptionizer;

use Mabs\ExceptionizerBundle\Event\FilterExceptionizerEvent;
use Mabs\ExceptionizerBundle\ExceptionizerEvents;

class Thrower implements Common\ThrowerInterface
{
    private $dispatcher;

    function __construct($eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;
    }

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
        $this->dispatchPreThrow($exception);

        throw $exception;
    }

    /**
     * @param \Exception $exception
     */
    protected function dispatchPreThrow($exception)
    {
        $event = new FilterExceptionizerEvent($exception);
        $this->dispatcher->dispatch(ExceptionizerEvents::EXCEPTIONIZER_PRE_THROW, $event);
    }
}
