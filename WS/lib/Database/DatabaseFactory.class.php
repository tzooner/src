<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/6/2015
 * Time: 11:48 AM
 */

namespace lib\Database;


use lib\Database\Drivers\MysqlDriver;

class DatabaseFactory{

    public static function create(){

        $type = \Config::DB_Type;

        switch($type){
            case "mysql":
                return MysqlDriver::getInstance();
            case "mssql":
                return MysqlDriver::getInstance();
            default:
                throw new \Exception("Unknown driver");
        }

    }

}