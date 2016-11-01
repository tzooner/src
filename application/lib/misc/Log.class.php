<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 9. 7. 2015
 * Time: 21:54
 */

namespace lib\misc;

class Log {

    private static $instance = false;
    private $File;

    private function __construct(){
        $filePath = \ConfigGeneral::APP_PATH . \ConfigGeneral::LOG_NAME;
        $this->File = new File($filePath);
    }

    public static function getInstance(){

        if(self::$instance === false){
            self::$instance = new Log();
        }

        return self::$instance;

    }

    /**
     * Zaloguje chybu do souboru
     *
     * @param $logName
     * @param $message
     */
    public function logError($logName, $message){

        $time = date(\ConfigGeneral::FORMAT_DATE_TIME);
        $logText = sprintf("[%s]\t%s\t|\t%s\n", $logName, $time, $message);

        $this->File->writeToFile($logText);

    }

} 