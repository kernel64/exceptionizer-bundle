<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 21/06/2015
 */
namespace Mabs\ExceptionizerBundle\Exceptionizer\Common;

interface CatcherInterface
{

    /**
     * @param string $className
     * @param callable $callback
     * @return bool
     * @throws \Exception
     */
    public function trap($className, \Closure $callback);
}
