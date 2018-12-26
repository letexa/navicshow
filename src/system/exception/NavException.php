<?php

namespace navic\exception;

class NavException extends \Exception {
    
    public function __construct($message, $code = 0, $response = null, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        return $this;
    }
}