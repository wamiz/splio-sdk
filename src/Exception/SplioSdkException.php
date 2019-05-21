<?php
/**
 * SplioSdkException.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Exception;

use \Exception;

class SplioSdkException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
