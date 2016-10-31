<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Constants;
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
                return DatabaseFactory::create()->getLastInsertedId();
            }

            return false;

        }
        catch(\PDOException $e){
            return array();
        }

    }

    private function updatePowerplant($data, $powerplantID){

        try {

            $sql = "UPDATE PowerPlant SET %s WHERE PowerPlantID = %d";
            $sqlValues = "";
            foreach ($data as $columnName => $item) {
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

}