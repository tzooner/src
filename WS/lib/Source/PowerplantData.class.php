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

        $S = new Settings();
        $colDef = $S->getColumnsDefinitions($powerplantID);

        $columns = "";
        foreach ($colDef as $col) {
            $columns .= sprintf("AVG(PD.%s) AS AVG_%s,", $col["ColumnName"], $col["ColumnName"]);
            $columns .= sprintf("MIN(PD.%s) AS AVG_%s,", $col["ColumnName"], $col["ColumnName"]);
            $columns .= sprintf("MAX(PD.%s) AS AVG_%s,", $col["ColumnName"], $col["ColumnName"]);
        }

        $columns = rtrim($columns, ",");

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

    public function getPowerplantDataColumns($powerPlantID){


        try {

            $Settings = new Settings();
            $ignoreBool = (intval($powerPlantID) > 0);
            $result = $Settings->getColumnsDefinitions($powerPlantID);

            $definition = array();
            foreach ($result as $row) {
                $columnName = $row["ColumnName"];
                $columnDef = $row["Definition"];
                $definition[$columnName] = $columnDef;
            }

            return $definition;
        }
        catch(\Exception $e){
            throw new cDatabaseException();
        }

    }

    public function saveImportLog($importDate, $importedRows, $errors, $warnings, $ipAddress){
        // Import je uspesny, pokud nenastanou chyby
        $isSuccess = (empty($errors) ? 1 : 0);

        $query = sprintf("INSERT INTO ImportLog(ImportDate, WasSuccess, ImportedRows, ImportErrors, ImportWarnings, IP) VALUES('%s', %d, %d, '%s', '%s', '%s')",
            $importDate, $isSuccess, $importedRows, $errors, $warnings, $ipAddress);

        return (@DatabaseFactory::create()->exec($query) == 1);

    }

}