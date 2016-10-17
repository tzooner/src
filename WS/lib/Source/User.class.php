<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Database\DatabaseFactory;
use lib\Helper\GeneralHelper;

class User
{

    public function getAllUsers(){

        $query = "SELECT
                         UserID
                        ,Username
                        ,Email
                        ,r.RoleID
                        ,r.Name AS RoleName
                        ,r.Description AS RoleDescription
                      FROM `user` u
                      INNER JOIN Role r ON u.RoleID_FK = r.RoleID
                      ORDER BY UserID";
        return @DatabaseFactory::create()->getAllRows($query);

    }

    public function loginUser($username, $password){

        $password = GeneralHelper::HashPassword($password);

        $query = sprintf("
                      SELECT
                         UserID
                        ,Username
                        ,Email
                        ,r.RoleID
                        ,r.Name AS RoleName
                        ,r.Description AS RoleDescription
                      FROM `user` u
                      INNER JOIN Role r ON u.RoleID_FK = r.RoleID
                      WHERE username='%s' AND password='%s'",
            $username, $password);

            $result = @DatabaseFactory::create()->getOneRow($query);
            return $result;

    }

}