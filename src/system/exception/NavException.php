<?php

namespace navic\exception;

class NavException extends \Exception {
    
    public function __construct($message, $code = 0, $response = null, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        
        if ($response) {
            $response->withStatus($this->code)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    'code' => $this->code, 
                    'message' => $this->message
                ]));
        } else {
            die($this->__toString());
        }
        
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}