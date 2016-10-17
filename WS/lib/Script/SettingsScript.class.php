<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/19/2015
 * Time: 9:13 PM
 */

namespace lib\Script;

use lib\Constants;
use lib\Misc\ProcessData;
use lib\Source\Settings;

class SettingsScript extends Script
{

    protected $Settings;

    public function __construct(){
        parent::__construct();
        $this->Settings = new Settings();
    }

    public function processMethodGET($parameters, $verb){

        if(!empty($verb)){

            switch($verb){
                case "colDef":
                    $powerPlantID = (isset($parameters[0]) ? intval($parameters[0]) : "");
                    $result = $this->Settings->getColumnsDefinitions($powerPlantID);
                    $count = (count($result) > 0 ? 1 : 0);
                    break;
                default:
                    $result = $this->User->getAllUsers();
                    $count = count($result);

            }

            $this->Response->setData($result);
            $this->Response->setReturnedRows($count);

        }
        else{

            $result = $this->User->getAllUsers();
            $count = count($result);

            $this->Response->setData($result);
            $this->Response->setReturnedRows($count);

        }

        return $this->Response->getResponseJson();

    }

    public function processMethodPOST($parameters, $verb, $request){

    }

    /**
     * Zpracuje prichozi data a vzdy vrati aktualni datum
     *
     * @param $parameters
     * @param $fileData
     * @return bool|string
     */
    public function processMethodPUT($parameters, $fileData){


    }

}