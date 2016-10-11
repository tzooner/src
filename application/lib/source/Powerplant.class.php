<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.03.2016
 * Time: 20:30
 */

namespace lib\source;

use lib\Constants;
use lib\helper\Response;
use lib\webservice\WebService;

class Powerplant{

    private $Webservice;

    public function __construct(WebService $webService){
        $this->Webservice = $webService;
    }

    public function GetAllPowerPlantData(){

        $data = $this->Webservice->callMethod(Constants::WS_URL_POWERPLANT);
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

    /**
     * Vrati nazvy sloupcu tabulky, kam se ukladani namerene hodnoty
     * @return array
     */
    public function GetColumns(){

        $url = sprintf("%s/columns", Constants::WS_URL_POWERPLANT_DATA);

        $data = $this->Webservice->callMethod($url);
        return Response::getData($data);

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