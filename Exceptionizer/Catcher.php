<?php
/**
 * Created by demoTrunk.
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 21/06/2015
 */

namespace Mabs\ExceptionizerBundle\Exceptionizer;


class Catcher implements Common\CatcherInterface
{

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
            if (get_class($e) === $className) {
                return true;
            }
        }

        return false;
    }
}
