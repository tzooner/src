<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:10 PM
 */

namespace lib\Source;

use lib\Database\DatabaseFactory;

class Powerplant
{

    public function getAllPowerPlants(){

        $query = "SELECT
                  *
                  FROM PowerPlant P INNER JOIN Facility F on P.FacilityID_FK = F.FacilityID
                  ORDER BY P.PowerPlantName";

        try {
            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\PDOException $e){
            return array();
        }

    }

    public function getPowerPlant($powerPlantID){

        $query = sprintf("SELECT
                          *
                          FROM
                            PowerPlant P
                          INNER JOIN Facility F on P.FacilityID_FK = F.FacilityID
                          WHERE
                            P.PowerPlantID = %d
                          ORDER BY
                            P.PowerPlantName
                          ", $powerPlantID);

        try {
            $result = @DatabaseFactory::create()->getAllRows($query);
            return $result;
        }
        catch(\PDOException $e){
            return array();
        }

    }

}