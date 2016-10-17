<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 19.09.2016
 * Time: 21:57
 */

namespace lib\helper;


class URL
{

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

    public static function redirect($pageName, $action = "", array $parameters = array()){

        $url = "?page=" . $pageName;
        if(!empty($action)){
            $url .= "&action=" . $action;
        }

        foreach ($parameters as $key=>$value) {
            if(!empty($key)){
                $url .= sprintf("&%s=%s", $key, $value);
            }
        }

        header("Location: " . $url);

    }

    public static function getActualURL(){
        return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
    }

}