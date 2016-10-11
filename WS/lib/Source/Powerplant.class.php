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
                            PowerPlantID = %d
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

}