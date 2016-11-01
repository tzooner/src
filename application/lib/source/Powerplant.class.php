<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.03.2016
 * Time: 20:30
 */

namespace lib\source;

use lib\Authorization;
use lib\Constants;
use lib\ErrorCodes;
use lib\helper\Response;
use lib\webservice\CURL;
use lib\webservice\WebService;

class Powerplant{

    private $Webservice;

    public function __construct(WebService $webService){
        $this->Webservice = $webService;
    }

    public function GetAllPowerPlant(){


        if(Authorization::isUserAdmin()) {
            $data = $this->Webservice->callMethod(Constants::WS_URL_POWERPLANT);
        }
        else{
            $url = sprintf("%s/user/%d", Constants::WS_URL_POWERPLANT, Authorization::getUserID());
            $data = $this->Webservice->callMethod($url);
        }
        return Response::getData($data);

    }

    public function GetPowerPlantData($powerplantID){

        $powerplantID = intval($powerplantID);

        if($powerplantID <= 0){
            return null;
        }

        $data = $this->Webservice->callMethod(Constants::WS_URL_POWERPLANT . "/" . $powerplantID);
        return Response::getData($data, true);

    }

    /**
     * @param $powerplantID
     * @param $datetimeFrom
     * @param $datetimeTo
     * @param string $valueType Nazev sloupce, ze ktere se ziskaji hodnoty. Pouzije se trida VauleType
     * @return array|null
     */
    public function GetPowerPlantDataInterval($powerplantID, $datetimeFrom, $datetimeTo, $valueType = ""){

        $powerplantID = intval($powerplantID);

        if($powerplantID <= 0){
            return null;
        }

        $url = sprintf("%s/interval/%d/%s/%s/%s", Constants::WS_URL_POWERPLANT_DATA, $powerplantID, $datetimeFrom, $datetimeTo, $valueType);
        $data = $this->Webservice->callMethod($url);
        return Response::getData($data);

    }

    public function GetDataOverview($powerplantID, $dateFrom, $dateTo){

        $powerplantID = intval($powerplantID);

        if($powerplantID <= 0){
            return null;
        }

        $url = sprintf("%s/overview/%d/%s/%s", Constants::WS_URL_POWERPLANT_DATA, $powerplantID, $dateFrom, $dateTo);

        $data = $this->Webservice->callMethod($url);
        return Response::getData($data, true);

    }

    public function GetDataSimpleOverview($dateFrom, $dateTo){

        $url = sprintf("%s/overview/%s/%s", Constants::WS_URL_POWERPLANT, $dateFrom, $dateTo);
        $url = sprintf("%s/overview/%s/%s", Constants::WS_URL_POWERPLANT, "", "");
        $data = $this->Webservice->callMethod($url);
        return Response::getData($data);

    }

    /**
     * Vrati nazvy sloupcu tabulky, kam se ukladani namerene hodnoty
     * @return array
     */
    public function GetColumns($powerPlantID){

        $url = sprintf("%s/columns/%d", Constants::WS_URL_POWERPLANT_DATA, $powerPlantID);

        $data = $this->Webservice->callMethod($url);
        return Response::getData($data);

    }

    public function SavePowerPlant($powerPlantID, $data){

        $url = sprintf("%s/%d", Constants::WS_URL_POWERPLANT, $powerPlantID);
        $response = $this->Webservice->callMethod($url, $data, CURL::REQUEST_TYPE_POST);;
        $errorCode = Response::getErrorCode($response);

        if($errorCode != ErrorCodes::WS_NO_ERROR){
            return Response::getMessage($response);
        }
        return (!empty($powerPlantID) ? $powerPlantID : Response::getInsertedId($response));

    }

    public function DeletePowerplant($powerplantID){

        if(Authorization::isUserAdmin()){

            $methodURL = sprintf('%s/%d', Constants::WS_URL_POWERPLANT, $powerplantID);
            $result = $this->Webservice->callMethod($methodURL, '', CURL::REQUEST_TYPE_DELETE);

            return Response::getErrorCode($result);

        }
        else{
            return ErrorCodes::WS_AUTHORIZATION_FAILED;
        }

    }

    public function GetAverageValueInterval($powerplantID, $datetimeFrom, $datetimeTo, $valueType = ""){
        // TODO?
    }

    public function GetMinValueInterval($powerplantID, $datetimeFrom, $datetimeTo, $valueType = ""){
        // TODO?
    }

    public function GetMaxValueInterval($powerplantID, $datetimeFrom, $datetimeTo, $valueType = ""){
        // TODO?
    }


}