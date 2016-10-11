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

}