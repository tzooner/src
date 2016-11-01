<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 17.10.2016
 */


namespace lib\source;


use lib\Constants;
use lib\ErrorCodes;
use lib\helper\Response;
use lib\webservice\CURL;

class Settings extends Source
{

    public function getColumnsDefinition($powerPlantID){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/colDef/%d', Constants::WS_URL_SETTINGS, $powerPlantID);

        $result = $this->WebService->callMethod($methodURL);

        return $result;

    }

    public function getAvailableColumns($powerPlantID){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/columns/%d', Constants::WS_URL_SETTINGS, $powerPlantID);

        $result = $this->WebService->callMethod($methodURL);

        return Response::getData($result);

    }

    public function saveColumnsDefinition($data){

        $result = $this->WebService->callMethod(Constants::WS_URL_SETTINGS, $data, CURL::REQUEST_TYPE_POST);
        return (Response::getErrorCode($result) == ErrorCodes::WS_NO_ERROR);

    }

}