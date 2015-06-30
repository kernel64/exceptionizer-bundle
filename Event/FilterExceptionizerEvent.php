<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 30/06/2015
 */

namespace Mabs\ExceptionizerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterExceptionizerEvent extends Event
{
    protected $exception;

    public function __construct(\Exception $e)
    {
        $this->exception = $e;
    }

    public function getException()
    {
        return $this->exception;
    }
}
