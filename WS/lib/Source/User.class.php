<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Database\DatabaseFactory;

class User
{

    public function getAllUsers(){

        $query = "SELECT UserID, Username, Email FROM user ORDER BY UserID";
        return @DatabaseFactory::create()->getAllRows($query);

    }

    public function loginUser($username, $password){

//        $username = $this->Database->checkString($username);
//        $password = self::hashPassword($this->Database->checkString($password));

        $query = sprintf("
                      SELECT
                         UserID
                        ,Username
                        ,Email
                      FROM `user`
                      WHERE username='%s' AND password='%s'",
            $username, $password);

            $result = @DatabaseFactory::create()->getOneRow($query);
            return $result;

    }

}