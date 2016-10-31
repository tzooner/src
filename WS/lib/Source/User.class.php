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
                      WHERE u.Deleted IS NULL
                      ORDER BY UserID";
        return @DatabaseFactory::create()->getAllRows($query);

    }

    public function getPowerplantUsers($powerplantID){

        $query = sprintf("SELECT
                         UserID
                        ,Username
                        ,Email
                      FROM `user2powerplant` u2p
                      INNER JOIN `user` u ON u2p.UserID_FK = u.UserID
                      WHERE u.Deleted IS NULL AND u2p.PowerplantID_FK = %d", $powerplantID);

        return @DatabaseFactory::create()->getAllRows($query);

    }

    public function geUser($userID){

        $query = sprintf("SELECT
                         UserID
                        ,Username
                        ,Email
                        ,r.RoleID
                        ,r.Name AS RoleName
                        ,r.Description AS RoleDescription
                      FROM `user` u
                      INNER JOIN Role r ON u.RoleID_FK = r.RoleID
                      WHERE u.Deleted IS NULL AND u.UserID = %d", $userID);

        return @DatabaseFactory::create()->getOneRow($query);

    }

    public function save($data, $userID){

        if(intval($userID) > 0){  // Update
            return $this->updateUser($data, $userID);
        }
        else{   // Insert
            return $this->createUser($data);
        }

    }

    private function createUser($data){

        try {

            $sql = "INSERT INTO user(%s) VALUES(%s)";
            $sqlColumns = "";
            $sqlValues = "";
            foreach ($data as $columnName => $item) {
                $value = GeneralHelper::GetValueOrNull($item);
                $sqlValues .= sprintf("%s,", $value);
                $sqlColumns .= sprintf("%s,", $columnName);
            }
            $sqlValues = rtrim($sqlValues,",");
            $sqlColumns = rtrim($sqlColumns,",");

            $sql = sprintf($sql, $sqlColumns, $sqlValues);
            if(DatabaseFactory::create()->exec($sql) == "1"){
                return DatabaseFactory::create()->getLastInsertedId();
            }

            return false;

        }
        catch(\PDOException $e){
            return array();
        }

    }

    private function updateUser($data, $powerplantID){

        try {

            $sql = "UPDATE user SET %s WHERE UserID = %d";
            $sqlValues = "";
            foreach ($data as $columnName => $item) {

                // Pokud u editace neni vyplneno heslo, tak jej uzivatel nezmenil a tudiz se nebude aktualizovat
                if($columnName == "Password" && empty($item)){
                    continue;
                }
                else{
                    $item = GeneralHelper::HashPassword($item);
                }

                $value = GeneralHelper::GetValueOrNull($item);
                $sqlValues .= sprintf("%s=%s,", $columnName, $value);
            }
            $sqlValues = rtrim($sqlValues,",");

            $sql = sprintf($sql, $sqlValues, $powerplantID);

            return (DatabaseFactory::create()->exec($sql) !== false);

        }
        catch(\PDOException $e){
            return array();
        }

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