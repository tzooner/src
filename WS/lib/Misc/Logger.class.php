<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 28.10.2016
 */


namespace lib\Misc;

namespace lib\misc;

class Logger {

    private static $instance = false;
    private $File;

    private function __construct(){
        $filePath = \Config::APP_PATH . \Config::LOG_DEBUG_NAME;
        $this->File = new File($filePath);
    }

    public static function getInstance(){

        if(self::$instance === false){
            self::$instance = new Logger();
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

        $message = preg_replace('/\s+/', ' ', $message);
        $message = trim($message);

        $time = date(\Config::FORMAT_DATE_TIME);
        $logText = sprintf("[%s]\t%s\t|\t%s\n", $logName, $time, $message);

        $this->File->writeToFile($logText);

    }

}