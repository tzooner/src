<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 21.1.2015
 */

namespace lib\source;

use lib\Authorization;
use lib\Constants;
use lib\ErrorCodes;
use lib\helper\Response;
use lib\webservice\CURL;
use lib\webservice\WebService;

class Users {

    const ROLE_ADMIN = "admin";
    const ROLE_USER = "user";

    private $WebService;

    public function __construct(WebService $WebService){

        $this->WebService = $WebService;

    }

    public function GetAllUser(){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = Constants::WS_URL_USER;

        $result = $this->WebService->callMethod($methodURL);

        return Response::getData($result);

    }

    public function GetUser($userID){

        $userID = intval($userID);

        if($userID <= 0){
            return null;
        }

        $data = $this->WebService->callMethod(Constants::WS_URL_USER . "/" . $userID);
        return Response::getData($data, true);

    }

    public function Save($userID, $data){

        $url = sprintf("%s/%d", Constants::WS_URL_USER, $userID);
        $response = $this->WebService->callMethod($url, $data, CURL::REQUEST_TYPE_POST);
        $errorCode = Response::getErrorCode($response);

        if($errorCode != ErrorCodes::WS_NO_ERROR){
            return Response::getMessage($response);
        }
        return (!empty($userID) ? $userID : Response::getInsertedId($response));

    }

    public function loginUser($username, $password, $returnInArray = true){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/login/%s/%s', Constants::WS_URL_USER, $username, $password);

        $result = $this->WebService->callMethod($methodURL, '', '', $returnInArray);

        return $result;

    }

    public function DeleteUser($userID){

        if(Authorization::isUserAdmin()){

            $methodURL = sprintf('%s/%d', Constants::WS_URL_USER, $userID);
            $result = $this->WebService->callMethod($methodURL, '', CURL::REQUEST_TYPE_DELETE);

            return Response::getErrorCode($result);

        }
        else{
            return ErrorCodes::WS_AUTHORIZATION_FAILED;
        }

    }

} 