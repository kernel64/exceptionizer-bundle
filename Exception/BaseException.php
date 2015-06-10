<?php
/**
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 * Date: 10/06/2015
 */

namespace Mabs\ExceptionizerBundle\Exception;


class BaseException extends \Exception
{
    public function __construct($message, $file, $line, $code = 0, Exception $previous = null)
    {
        $this->file = $file;
        $this->line = $line;
        parent::__construct($message, $code, $previous);
    }
}
