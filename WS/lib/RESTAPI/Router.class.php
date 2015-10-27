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
use lib\Entity\Response;
use lib\Script\PowerPlantDataScript;
use lib\Source\Powerplant;

class Router extends REST{

    public function __construct($request, $method){
        parent::__construct($request, $method);

    }

    public function data(){

        $Script = new PowerPlantDataScript();
        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters);
                break;
            case "put":
                $Script->processMethodPUT($this->Parameters, $this->File);
                break;
        }

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