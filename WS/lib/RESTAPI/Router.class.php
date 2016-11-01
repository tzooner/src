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

use lib\Script\PowerPlantDataScript;
use lib\Script\PowerPlantScript;
use lib\Script\RoleDataScript;
use lib\Script\SettingsScript;
use lib\Script\UserDataScript;

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

        $Script = new PowerPlantScript();
        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
                break;
            case "post":
                return $Script->processMethodPOST($this->Parameters, $this->Request);
                break;
            case "delete":
                return $Script->processMethodDELETE($this->Parameters);
                break;
            default:
                return "Unsupported method";
        }

    }

    public function user(){

        $Script = new UserDataScript();

        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
            case "post":
                return $Script->processMethodPOST($this->Parameters, $this->Request);
            case "put":
                return $Script->processMethodPUT($this->Parameters, $this->File);
                break;
            case "delete":
                return $Script->processMethodDELETE($this->Parameters);
                break;
            default:
                return "Unsupported method";
        }

    }


    public function settings(){

        $Script = new SettingsScript();
        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
                break;
            case "post":
                return $Script->processMethodPOST($this->Parameters, $this->Request);
            default:
                return "Unsupported method";
        }

    }

    public function role(){

        $Script = new RoleDataScript();

        switch(strtolower($this->HttpMethod)){
            case "get":
                return $Script->processMethodGET($this->Parameters, $this->Verb);
            case "post":
                return $Script->processMethodPOST($this->Parameters, $this->Request);
            case "put":
                return $Script->processMethodPUT($this->Parameters, $this->File);
                break;
            default:
                return "Unsupported method";
        }

    }

}