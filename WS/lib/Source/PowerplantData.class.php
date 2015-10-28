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
    public function getPowerplantData($powerplantID){

        $query = sprintf("
              SELECT
                PD.*,
                P.PowerPlantID,
                P.PowerPlantName
              FROM PowerplantData PD
              INNER JOIN Powerplant P ON PD.PowerPlantID_FK = P.PowerPlantID
              WHERE P.PowerPlantID = %d
              ORDER BY P.PowerPlantID,PD.PowerPlantDataID", $powerplantID);

        try {
            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\PDOException $e){
            return array();
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