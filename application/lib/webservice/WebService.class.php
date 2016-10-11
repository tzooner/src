<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 19.1.2015
 */

namespace lib\webservice;

use lib\ErrorCodes;

class WebService {

//    private static $WebService;
    private $CURL;
    private $lastCallReturnCode = '';

    public function __construct(CURL $CURL){
        $this->CURL = $CURL;
    }

    public function callMethod($methodURL, $data = '', $requestType = '', $returnInArray = TRUE){

        // Kodovani URL krome lomitka
        $methodURL = implode('/', array_map('urlencode', explode('/', $methodURL)));

        if(!empty($methodURL)){

            $this->CURL->createCurl($methodURL, $requestType, $data);

            // Get result in JSON
            $resultJSON = $this->CURL->getPage();

            // If all OK
            if($this->CURL->getHttpStatus() == '200'){

                $resultArray = json_decode($resultJSON, TRUE);


                // If no error in JSON parsing
                if(json_last_error() == JSON_ERROR_NONE){

                    // Try to read return code
                    $returnCode = (isset($resultArray['ERROR_CODE']) ? $resultArray['ERROR_CODE'] : ErrorCodes::APP_NO_RETURN_CODE);

                    $this->setReturnCode($returnCode);

                    if($returnInArray){
                        return $resultArray;
                    }
                    else{
                        return $resultJSON;
                    }

                }
                else{

                    $this->setReturnCode(ErrorCodes::APP_JSON_PARSE_ERROR);

                }

            }
            else{

                $this->setReturnCode(ErrorCodes::APP_BAD_URL);

            }

        }
        else{

            $this->setReturnCode(ErrorCodes::APP_BAD_URL);

        }

        return '';

    }

    public function callMethodForPrint($methodURL){

        if(!empty($methodURL)){

            $this->CURL->createCurl($methodURL);

            // Get result in JSON
            $result = $this->CURL->getPage();

            // If all OK
            if($this->CURL->getHttpStatus() == '200'){

                return $result;

            }
            else{

                $this->setReturnCode(ErrorCodes::APP_BAD_URL);

            }

        }
        else{

            $this->setReturnCode(ErrorCodes::APP_BAD_URL);

        }

        return '';

    }

    private function setReturnCode($returnCode){

        $this->lastCallReturnCode = $returnCode;

    }

    public function getLastReturnCode(){

        return $this->lastCallReturnCode;

    }

    public function getLastReturnCodeMsg(){

        switch($this->getLastReturnCode()){

            case ErrorCodes::WS_NO_ERROR:
                return 'No error';
                break;
            case ErrorCodes::WS_DATABASE_CONNECTION_FAILURE:
                return 'Connecting to database failed.';
                break;
            case ErrorCodes::WS_DATABASE_SYSTEM_FAILURE:
                return 'Database script failed.';
                break;
            case ErrorCodes::WS_PARAMETER_MISSING:
                return 'Sending data are not complete. Some parameter missing.';
                break;
            case ErrorCodes::WS_PARAMETER_FORMAT_ERROR:
                return 'Decoding data from server failed.';
                break;
            case ErrorCodes::WS_RECORD_NOT_EXIST:
                return 'Record does not exist in database.';
                break;
            case ErrorCodes::WS_RECORD_CREATE_PK_ERROR:
                return 'Creating a new guide ID failed.';
                break;
            case ErrorCodes::WS_AUTHORIZATION_FAILED:
                return 'Wrong username or password';
                break;
            case ErrorCodes::WS_UNKNOWN_ERROR:
                return 'Unknown error occurred.';
                break;

        }

    }

    private function processReturnCode(){

        $returnCode = $this->getLastReturnCode();

    }

}
