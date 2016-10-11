<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 10.10.2016
 * Time: 22:26
 */

namespace lib\helper;


class Number
{

    public static function round($value, $decimals = 2){
        return round($value, $decimals);
    }

}