<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 15.08.2016
 * Time: 22:49
 */

namespace lib\Exceptions;


class MException extends \Exception
{

    public function __construct($message, $code, \Exception $previous)
    {
        parent::__construct($message, $code, $previous);

        if(!\Config::IS_DEBUG){
            $this->exceptionToFile();
        }

    }

    public function errorMessage(){

        $err = sprintf("Error on line %d. Error message: '%s' in file: %s", $this->getLine(), $this->getMessage(), $this->getFile());

    }

    private function exceptionToFile(){

        $message = date("Y-m-d H:i:s") . " [ERROR] - " . get_class($this) . " - " . $this->getMessage() . "\n";
        $message .= $this->getTraceAsString();
        file_put_contents(\Config::LOG_PATH, $message, FILE_APPEND);

    }

}