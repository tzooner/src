<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


class General {

    public static function isSetOrEmpty($var){
        return (isset($var) ? $var : "");
    }

    /**
     * Vrati 0 pokud  je vstupni hodnota prazdna (empty) nebo null
     * @param $input
     * @return int
     */
    public static function ifNullZero($input){

        if(isset($input) && !empty($input)){
            return $input;
        }

        return 0;

    }

    /**
     * Nahradi vsechy whitespaces (v CZ?) mezerou nebo zvolenym retezcem
     *
     * @param $input
     * @param string $replaceBy
     * @return string
     */
    public static function removeWhitespaces($input, $replaceBy = " "){

        return preg_replace('/\s+/', $replaceBy, $input);

    }

    public static function clearSession($name){
        if(isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

} 