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

class PowerPlantDataScript extends Script
{

    public function __construct(){
        parent::__construct();
    }

    public function processMethodGET($parameters, $verb){

//        if(empty($parameters)){
//
//            $result = $this->PowerPlantData->getAllData();
//            $this->Response->setData($result);
//            $this->Response->setReturnedRows(count($result));
//
//        }


        if(!empty($verb)){

            $result = array();

            switch($verb){
                case "interval":

                    $powerplantID = (isset($parameters[0]) ? $parameters[0] : "");
                    $dateFrom = (isset($parameters[1]) ? $parameters[1] : "");
                    $dateTo = (isset($parameters[2]) ? $parameters[2] : "");
                    $columnName = (isset($parameters[3]) ? $parameters[3] : ""); // Vrati hodnoty pouze vybraneho sloupce

                    if(empty($powerplantID) || empty($dateFrom) || empty($dateTo)){
                        $this->Response->setErrorCode(Constants::RESPONSE_CODE_MISSING_PARAMETERS);
                        $this->Response->setMessage("Missing date interval");
                    }
                    else{
                        $result = $this->PowerPlantData->getPowerplantData($powerplantID, $dateFrom, $dateTo, $columnName);
                    }

                    break;
                case "overview":

                    $powerplantID = (isset($parameters[0]) ? $parameters[0] : "");
                    $dateFrom = (isset($parameters[1]) ? $parameters[1] : "");
                    $dateTo = (isset($parameters[2]) ? $parameters[2] : "");

                    if(empty($powerplantID)){
                        $this->Response->setErrorCode(Constants::RESPONSE_CODE_MISSING_PARAMETERS);
                        $this->Response->setMessage("Missing date");
                    }
                    else{
                        $result = $this->PowerPlantData->getPowerplantDataOverview($powerplantID, $dateFrom, $dateTo);
                    }

                    break;
                case "columns":

                    $result = $this->PowerPlantData->getPowerplantDataColumns();
                    break;

                default:
                    $result = $this->PowerPlantData->getAllData();
                    $this->Response->setData($result);

            }

            $this->Response->setData($result);

        }
        else{

            if(empty($parameters)){

                $result = $this->PowerPlantData->getAllData();
                $this->Response->setData($result);
                $this->Response->setReturnedRows(count($result));

            }
            else{

                $powerplantID = $parameters[0];

                $result = $this->PowerPlantData->getPowerplantData($powerplantID);
                $this->Response->setData($result);
                $this->Response->setReturnedRows(count($result));

            }

        }

        return $this->Response->getResponseJson();

    }

    /**
     * Zpracuje prichozi data a vzdy vrati aktualni datum
     *
     * @param $parameters
     * @param $fileData
     * @return bool|string
     */
    public function processMethodPUT($parameters, $fileData){

        try {
            $powerplantID = (isset($parameters[0]) ? $parameters[0] : 0);

            if($powerplantID > 0) {

                $filePath = sprintf("%sImport_%s/", \Config::FILE_PATH, date("Y-m"));
                $filename = sprintf("import_%s.txt", date("Y-m-d-H-i"));
                $Process = new ProcessData($filePath, $filename);
                $Process->saveToFile($fileData);
                $Process->importToDatabase($powerplantID);

            }
            else{
                return "No powerplant ID in URL";
            }

        }
        catch(\Exception $e){

        }

        return date("Y-m-d H:i:s");

    }

}