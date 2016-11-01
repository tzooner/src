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

    public function getAllPowerPlants($userID = ""){

        $facilities = $this->getAllFacilities();
        $User = new User();

        if(!empty($userID)){
            $query = sprintf("SELECT
                  *
                  FROM Powerplant p
                  LEFT JOIN user2powerplant u2p ON p.PowerPlantID = u2p.PowerPlantID_FK                                   
                  WHERE p.Deleted IS NULL AND u2p.UserID_FK = %d
                  ORDER BY PowerPlantName", $userID);
        }
        else{

            $query = "
                  SELECT
                    *
                  FROM Powerplant                  
                  WHERE Deleted IS NULL
                  ORDER BY PowerPlantName";

        }


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

    /**
     * Jednoduchy prehled pro neprihlasene uzivatele
     * @param $dateFrom
     * @param $dateTo
     * @return array
     */
    public function getPowerplantSimpleOverview($dateFrom, $dateTo){

        $where = "";

        if(!empty($dateFrom) && !empty($dateTo)){
            $dateFrom = date("Y-m-d H:i:s", strtotime($dateFrom));
            $dateTo = date("Y-m-d H:i:s", strtotime($dateTo));
            $where = sprintf("WHERE MeasurementTime >= '%s' AND MeasurementTime <= '%s' ", $dateFrom, $dateTo);
        }

        $S = new Settings();
        $def = $S->getPowerColumnDefinitions();

        $query = sprintf("
              SELECT 
                PowerPlantID_FK,PowerPlantName, Description, City, Street, LocationLongitude, LocationLatitude,
                #Power1, Power2, Power3, Power4, Power5,
                MIN(Power1) AS MIN_Power1, MIN(Power2) AS MIN_Power2, MIN(Power3) AS MIN_Power3, MIN(Power4) AS MIN_Power4, MIN(Power5) AS MIN_Power5,
                MAX(Power1) AS MAX_Power1, MAX(Power2) AS MAX_Power2, MAX(Power3) AS MAX_Power3, MAX(Power4) AS MAX_Power4, MAX(Power5) AS MAX_Power5,
                AVG(Power1) AS AVG_Power1, AVG(Power2) AS AVG_Power2, AVG(Power3) AS AVG_Power3, AVG(Power4) AS AVG_Power4, AVG(Power5) AS AVG_Power5
            FROM 
                powerplantdata pd
            INNER JOIN powerplant p on pd.PowerPlantID_FK = p.PowerPlantID
            %s
            GROUP BY PowerPlantID_FK,PowerPlantName, Description, City, Street, LocationLongitude, LocationLatitude
            ", $where);

        try {
            $result = @DatabaseFactory::create()->getAllRows($query);

            $toReturn = array();
            foreach ($result as $item) {    // Prochazeni jednotlivych dat z elektrarny

                $powerPlantID = $item["PowerPlantID_FK"];

                foreach ($item as $columnName => $cell) {   // Prochazeni dat po bunkach

                    $originalColName = substr($columnName, 4);
                    foreach ($def as $defRow) { // Hleda se shoda s nazvem sloupce a jeho definici
                        if($defRow["ColumnName"] == $originalColName && $defRow["PowerPlantID"] == $powerPlantID){

                            $item["Definition_".$originalColName] = $defRow["Definition"];

                        }
                    }

                }

                $toReturn[] = $item;

            }

            return $toReturn;
        }
        catch(\Exception $e){

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

//    private function savePowerPlantUsers($users, $powerplantID){
//
//        $delete = DatabaseFactory::create()->exec(sprintf("DELETE FROM user2powerplant WHERE PowerPlantID_FK = %d", $powerplantID));
//
//        $sql = "INSERT INTO user2powerplant(UserID_FK, PowerPlantID_FK) values(%s)";
//        foreach ($users as $user) {
//
//        }
//
//    }

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

    public function delete($powerplantID, $softDelete = true){

        if($softDelete) {
            $sql = sprintf("UPDATE `powerplant` SET deleted = CURRENT_TIMESTAMP WHERE `PowerPlantID` = %d", $powerplantID);
        }
        else{
            $sql = sprintf("DELETE FROM `powerplant` WHERE `PowerPlantID` = %d", $powerplantID);
        }
        return DatabaseFactory::create()->exec($sql);

    }

}