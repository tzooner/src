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
use lib\Script\SettingsScript;
use lib\Script\UserDataScript;
use lib\Source\Powerplant;
use lib\Source\User;

class Router extends REST{

    public function __construct($request, $method){
        parent::__construct($request, $method);

    }

    public function data(){

        $Script = new PowerPlantDataScript();
        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
                break;
            case "put":
                return $Script->processMethodPUT($this->Parameters, $this->File);
                break;
            default:
                return "Unsupported method";
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

            $powerplantID = intval($this->Parameters[0]);

            if(isset($powerplantID) && $powerplantID > 0) {
                $result = $PowerPlant->getPowerPlant($powerplantID);
                $Response->setData($result);
                $Response->setReturnedRows(count($result));
            }
            else{
                $Response->setMessage("No powerplant ID");
            }

        }

        return $Response->getResponseJson();

    }

    public function user(){

        $Script = new UserDataScript();

        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
            case "post":
                return $Script->processMethodPOST($this->Parameters, $this->Verb, $this->Request);
            case "put":
                return $Script->processMethodPUT($this->Parameters, $this->File);
                break;
            default:
                return "Unsupported method";
        }

    }

    public function settings(){

        $Script = new SettingsScript();
        return $Script->processMethodGET($this->Parameters, $this->Verb);

    }

}