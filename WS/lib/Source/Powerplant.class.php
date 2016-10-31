<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Constants;
use lib\Database\Database;
use lib\Database\DatabaseFactory;
use lib\Helper\GeneralHelper;

class Powerplant
{


    public function getAllFacilities(){

        $query = "SELECT
                  *
                  FROM Facility
                  ORDER BY FacilityName";

        try {

            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\PDOException $e){
            return array();
        }

    }

    public function getAllPowerPlants(){

        $facilities = $this->getAllFacilities();
        $User = new User();

        $query = "SELECT
                  *
                  FROM Powerplant
                  WHERE Deleted IS NULL
                  ORDER BY PowerPlantName";

        try {

            $powerplants = @DatabaseFactory::create()->getAllRows($query);
            $result = array();
            foreach ($powerplants as $powerplant) {

                $powerplant["Facilities"] = array();
                $powerPlantID = $powerplant["PowerPlantID"];
                foreach ($facilities as $facility) {
                    if($powerPlantID == $facility["PowerPlantID_FK"]){
                        $powerplant["Facilities"][] = $facility;
                    }
                }

                $powerplant["Users"] = $User->getPowerplantUsers($powerPlantID);

                $result[] = $powerplant;

            }

            return $result;

        }
        catch(\PDOException $e){
            return array();
        }

    }

    public function getPowerPlant($powerPlantID){

        $facilities = $this->getAllFacilities();

        $User = new User();

        $query = sprintf("SELECT
                          *
                          FROM
                            Powerplant
                          WHERE
                            PowerPlantID = %d AND Deleted IS NULL
                          ORDER BY
                            PowerPlantName
                          ", $powerPlantID);

        try {
            $powerplants = @DatabaseFactory::create()->getAllRows($query);

            $result = array();
            foreach ($powerplants as $powerplant) {


                $powerplant["Facilities"] = array();
                $powerPlantID = $powerplant["PowerPlantID"];
                foreach ($facilities as $facility) {
                    if($powerPlantID == $facility["PowerPlantID_FK"]){
                        $powerplant["Facilities"][] = $facility;
                    }
                }

                $powerplant["Users"] = $User->getPowerplantUsers($powerPlantID);

                $result[] = $powerplant;

            }

            return $result;

        }
        catch(\PDOException $e){
            return array();
        }

    }

    public function savePowerPlant($data, $powerPlantID){

        if(intval($powerPlantID) > 0){  // Update
            return $this->updatePowerplant($data, $powerPlantID);
        }
        else{   // Insert
            return $this->createPowerplant($data);
        }

    }

    private function savePowerPlantUsers($users, $powerplantID){

        $delete = DatabaseFactory::create()->exec(sprintf("DELETE FROM user2powerplant WHERE PowerPlantID_FK = %d", $powerplantID));

        $sql = "INSERT INTO user2powerplant(UserID_FK, PowerPlantID_FK) values(%s)";
        foreach ($users as $user) {

        }

    }

    private function createPowerplant($data){

        try {

            $Users = $data["UserID_FK"];
            unset($data["UserID_FK"]);


            $sql = "INSERT INTO PowerPlant(%s) VALUES(%s)";
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

                $lastInsertedId = DatabaseFactory::create()->getLastInsertedId();

                $this->createBindingUser2Powerplant($Users, $lastInsertedId);
                return $lastInsertedId;


            }

            return false;

        }
        catch(\PDOException $e){
            return array();
        }

    }

    private function updatePowerplant($data, $powerplantID){

        try {

            $Users = $data["UserID_FK"];
            unset($data["UserID_FK"]);

            $sql = "UPDATE PowerPlant SET %s WHERE PowerPlantID = %d";
            $sqlValues = "";
            foreach ($data as $columnName => $item) {
                $value = GeneralHelper::GetValueOrNull($item);
                $sqlValues .= sprintf("%s=%s,", $columnName, $value);
            }
            $sqlValues = rtrim($sqlValues,",");

            $sql = sprintf($sql, $sqlValues, $powerplantID);

            $updatePowerplantResult = (DatabaseFactory::create()->exec($sql) !== false);

            DatabaseFactory::create()->exec(sprintf("DELETE FROM user2powerplant WHERE PowerPlantID_FK=%d", $powerplantID));
            $this->createBindingUser2Powerplant($Users, $powerplantID);

            return $updatePowerplantResult;


        }
        catch(\PDOException $e){
            return array();
        }

    }

    private function createBindingUser2Powerplant($userData, $powerplantID){

        // Ulozeni vazby elektrarny na uzivatele
        $userQuery = "INSERT INTO user2powerplant(UserID_FK, PowerPlantID_FK) VALUES";
        foreach ($userData as $user) {
            $userQuery .= sprintf("(%d, %d),", $user, $powerplantID);
        }
        $userQuery = rtrim($userQuery, ",");

        return DatabaseFactory::create()->exec($userQuery);

    }

}