<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/6/2015
 * Time: 11:54 AM
 */

namespace lib\Database\Drivers;

use lib\Database\Database;
use \Config;

class MysqlDriver extends Database{

	private static $Instance = null;

    protected function __construct($hostname, $dbName, $username, $password, $dbType){
        parent::__construct($hostname, $dbName, $username, $password, $dbType);
    }

    public static function getInstance(){

        if (self::$Instance === null) {
            self::$Instance = new MysqlDriver(\Config::DB_Host, \Config::DB_Name, \Config::DB_Username, \Config::DB_Password, "mysql");
        }
        return self::$Instance;

    }

}