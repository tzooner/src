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

    public static function getParameter($name, $type = "get"){

        $type = strtolower($type);
        $value = "";

        switch($type){
            case "get":
                if(!isset($_GET[$name])){
                    return "";
                }
                if(is_array($_GET[$name])){
                    $value = $_GET[$name];
                }
                else {
                    $value = @filter_input(INPUT_GET, $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
                break;
            case "post":
                if(!isset($_POST[$name])){
                    return "";
                }
                if(is_array($_POST[$name])){
                    $value = $_POST[$name];
                }
                else {
                    $value = @filter_input(INPUT_POST, $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
        }
        if(isset($value)){
            return $value;
        }

        return "";

    }

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