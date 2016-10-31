<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 31.10.2016
 */


namespace lib\Misc;


class Auth
{

    public static function getBasicAuthUsername(){
        return $_SERVER["PHP_AUTH_USER"];
    }

    public static function getBasicAuthPassword(){
        return $_SERVER["PHP_AUTH_PW"];
    }

}