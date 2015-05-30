<?php

namespace Eps\VhostGeneratorBundle\Generator\Exception;

class ValidationException extends \Exception
{
    /**
     * @param string $message
     * @param string $context
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $context = '', $code = 0, \Exception $previous = null)
    {
        if ($context) {
            $message = $message . " ($context)";
        }

        parent::__construct($message, $code, $previous);
    }
}
