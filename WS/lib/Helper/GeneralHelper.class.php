<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 8:47 PM
 */

namespace lib\Helper;

class GeneralHelper
{

    /**
     * Pokud je vstupni hodnota nastavena (existuje), pak se vrati
     * Pokud neexistuje, vrati se prazdny retezec
     *
     * @param $value
     * @return string
     */
    public static function GetValueOrEmptyString($value){
        return (isset($value) ? $value : "");
    }

    /**
     * Pokud je vstupni hodnota nastavena (existuje), pak se vrati
     * Pokud neexistuje, vrati se NULL
     *
     * @param $value
     * @return string
     */
    public static function GetValueOrNull($value){
        return (isset($value) ? "'" . $value . "'" : null);
    }

    public static function HashPassword($password){

        return $password;

        // TODO povolit hashovani
        $salt = \Config::SECURITY_HASH_SALT;
        return sha1(sprintf("%s%s", $salt, md5($password)));

    }

}