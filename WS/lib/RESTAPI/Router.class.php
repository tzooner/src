<?php
/**
 * Smerovani jednotlivych stranek
 * Co metoda, to stranka v URL
 * Napr.: WS/Example vola metodu example()
 *
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 8:26 PM
 */

namespace lib\RESTAPI;

use lib\Constants;
use lib\Database\DatabaseFactory;
use lib\Entity\Response;
use lib\Source\Powerplant;
use lib\Source\PowerplantData;

class Router extends REST{

    public function __construct($request, $method){
        parent::__construct($request, $method);

    }

    public function data(){

        $Response = new Response();
        $Response->setErrorCode(Constants::RESPONSE_CODE_NO_ERROR);

        $PowerPlantData = new PowerplantData();

        if(empty($this->Parameters)){

            $result = $PowerPlantData->getAllData();
            $Response->setData($result);
            $Response->setReturnedRows(count($result));

        }
        else{

            $powerplantID = $this->Parameters[0];

            $result = $PowerPlantData->getPowerplantData($powerplantID);
            $Response->setData($result);
            $Response->setReturnedRows(count($result));

        }

        return $Response->getResponseJson();

    }
    public function powerplant(){

        $Response = new Response();
        $Response->setErrorCode(Constants::RESPONSE_CODE_NO_ERROR);

        $PowerPlant = new Powerplant();

        if(empty($this->Parameters)){

            $result = $PowerPlant->getAllPowerPlants();
            $Response->setData($result);
            $Response->setReturnedRows(count($result));

        }
        else{

            $powerplantID = $this->Parameters[0];

            $result = $PowerPlant->getPowerPlant($powerplantID);
            $Response->setData($result);
            $Response->setReturnedRows(count($result));

        }

        return $Response->getResponseJson();

    }

}