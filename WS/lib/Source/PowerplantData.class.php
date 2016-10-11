<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Database\Database;
use lib\Database\DatabaseFactory;
use lib\Exceptions\cDatabaseException;
use lib\Exceptions\cException;

class PowerplantData
{

    public function __construct(){}

    /**
     * Vrati vsechna data
     * @return array
     * @throws \Exception
     */
    public function getAllData(){

        $query = "
              SELECT
                PD.*,
                P.PowerPlantID,
                P.PowerPlantName
              FROM PowerplantData PD
              INNER JOIN Powerplant P ON PD.PowerPlantID_FK = P.PowerPlantID
              ORDER BY P.PowerPlantID,PD.PowerPlantDataID
              ";

        try {
            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\PDOException $e){
            return array();
        }

    }

    /**
     * Vrati vsechna data jen pro urcitou elektrarnu
     *
     * @param $powerplantID
     * @return array
     * @throws \Exception
     */
    public function getPowerplantData($powerplantID, $dateFrom = "", $dateTo = "", $columnName = ""){

        $where = "";

        if(!empty($dateFrom) && !empty($dateTo)){
            $dateFrom = date("Y-m-d H:i:s", strtotime($dateFrom));
            $dateTo = date("Y-m-d H:i:s", strtotime($dateTo));
            $where = sprintf(" AND MeasurementTime >= '%s' AND MeasurementTime <= '%s' ", $dateFrom, $dateTo);
        }

        if(!empty($columnName)){
            $columns = "PD." . $columnName;
        }
        else{
            $columns = "
                PD.*,
                P.PowerPlantID,
                P.PowerPlantName
            ";
        }


        $query = sprintf("
              SELECT
                %s
              FROM PowerplantData PD
              INNER JOIN Powerplant P ON PD.PowerPlantID_FK = P.PowerPlantID
              WHERE P.PowerPlantID = %d %s
              ORDER BY P.PowerPlantID,PD.PowerPlantDataID", $columns, $powerplantID, $where);

        try {

            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\Exception $e){
            throw new cDatabaseException();
        }

    }

    public function getPowerplantDataOverview($powerplantID, $dateFrom, $dateTo){

        $where = "";

        if(!empty($dateFrom) && !empty($dateTo)){
            $dateFrom = date("Y-m-d H:i:s", strtotime($dateFrom));
            $dateTo = date("Y-m-d H:i:s", strtotime($dateTo));
            $where = sprintf(" AND MeasurementTime >= '%s' AND MeasurementTime <= '%s' ", $dateFrom, $dateTo);
        }


        $query = sprintf("
              SELECT
                AVG(PD.Temp_AKU) AS AVG_Temp_AKU,
                MIN(PD.Temp_AKU) AS MIN_Temp_AKU,
                MAX(PD.Temp_AKU) AS MAX_Temp_AKU,
                AVG(PD.Temp_Boiler) AS AVG_Temp_Boiler,
                MIN(PD.Temp_Boiler) AS MIN_Temp_Boiler,
                MAX(PD.Temp_Boiler) AS MAX_Temp_Boiler,
                AVG(PD.Performance_Drive) AS AVG_Performance_Drive,
                MIN(PD.Performance_Drive) AS MIN_Performance_Drive,
                MAX(PD.Performance_Drive) AS MAX_Performance_Drive
              FROM PowerplantData PD
              INNER JOIN Powerplant P ON PD.PowerPlantID_FK = P.PowerPlantID
              WHERE P.PowerPlantID = %d %s
              ORDER BY P.PowerPlantID,PD.PowerPlantDataID", $powerplantID, $where);

        try {

            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\Exception $e){
            throw new cDatabaseException();
        }

    }

    public function getPowerplantDataColumns(){

        $columnNames = array(
            "Temp_AKU" => "Teplota AKU nádrže",
            "Temp_BoilerInput" => "Teplota vstupu do kotle",
            "Temp_DistributionInput" => "Teplota vstupu do rozvodu",
            "Temp_Boiler" => "Teplota bojleru",
            "Relay_BoilerPump" => "Rele cerpadlo bojleru",
            "Relay_RadiatorPump" => "Rele cerpadlo radiatou",
            "Relay_SwitchAKU" => "Rele stavu ventilu pri prepinani aku nadrze",
            "Relay_SwitchBoiler" => "Rele stavu ventilu pri prepinani kotel",
            "Relay_BoilerFlow1" => "Rele regulace prutoku kotle 1",
            "Relay_BoilerFlow2" => "Rele regulace prutoku kotle 2",
            "Relay_PumpFromBoiler" => "Rele cerpadlo z kotle",
            "Relay_BoilerHeating" => "Rele topeni v kotli",
            "Performance_Drive" => "Vykon menice (=panelu)",
            "Performance_Network" => "Vykon ze site",
            "Other_Optocoupler" => "Optoclen",
        );

        return $columnNames;

    }

    public function saveImportLog($importDate, $importedRows, $errors, $warnings, $ipAddress){
        // Import je uspesny, pokud nenastanou chyby
        $isSuccess = (empty($errors) ? 1 : 0);

        $query = sprintf("INSERT INTO ImportLog(ImportDate, WasSuccess, ImportedRows, ImportErrors, ImportWarnings, IP) VALUES('%s', %d, %d, '%s', '%s', '%s')",
            $importDate, $isSuccess, $importedRows, $errors, $warnings, $ipAddress);

        return (@DatabaseFactory::create()->exec($query) == 1);

    }

}