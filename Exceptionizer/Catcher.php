<?php
/**
 * Created by demoTrunk.
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 21/06/2015
 */

namespace Mabs\ExceptionizerBundle\Exceptionizer;

use Mabs\ExceptionizerBundle\Event\FilterExceptionizerEvent;
use Mabs\ExceptionizerBundle\ExceptionizerEvents;

class Catcher implements Common\CatcherInterface
{
    private $dispatcher;

    function __construct($eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;
    }

    /**
     * @param string $className
     * @param callable $callback
     * @return bool
     * @throws \Exception
     */
    public function trap($className, \Closure $callback)
    {
        try {
            call_user_func($callback);
        } catch (\Exception $e) {
            $this->dispatchPostCatch($e);
            if (get_class($e) === $className) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Exception $exception
     */
    protected function dispatchPostCatch($exception)
    {
        $event = new FilterExceptionizerEvent($exception);
        $this->dispatcher->dispatch(ExceptionizerEvents::Exceptionizer_POST_CATCH, $event);
    }
}
