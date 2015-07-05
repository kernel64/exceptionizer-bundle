<?php
/**
 * User: Mohamed Aymen Ben Slimane <aymen.kernel@gmail.com>
 * Date: 05/07/15
 * Time: 11:27 ص
 */

namespace Mabs\ExceptionizerBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Bridge\Monolog\Logger;

class MabsExceptionizerListener
{

    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onPreThrowException(Event $event)
    {
        $exception = $event->getException();
        $this->logger->addInfo($event->getName() . "[ " . get_class($exception) . " ]");
        $this->logger->addInfo($event->getName() . "[ " . $exception->getFile() . " - " . $exception->getLine() . " ]");
        $this->logger->addInfo($event->getName() . "[ " . $exception->getMessage() . " ]");
    }
}
