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
use lib\validators\UserValidator;

class UserDataScript extends Script
{

    public function __construct(){
        parent::__construct();
    }

    public function processMethodGET($parameters, $verb){

        if(!empty($verb)){

            switch($verb){
                case "login":
                    $username = (isset($parameters[0]) ? $parameters[0] : "");
                    $password = (isset($parameters[1]) ? $parameters[1] : "");
                    $result = $this->User->loginUser($username, $password);
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

            if(empty($parameters)){

                $result = $this->User->getAllUsers();
                $this->Response->setData($result);
                $this->Response->setReturnedRows(count($result));

            }
            else{

                $userID = intval($parameters[0]);

                if(isset($userID) && $userID > 0) {
                    $result = $this->User->getUser($userID);
                    $this->Response->setData($result);
                    $this->Response->setReturnedRows(count($result));
                }
                else{
                    $this->Response->setMessage("No powerplant ID");
                }

            }


        }

        return $this->Response->getResponseJson();

    }

    /**
     *
     *
     * @param $parameters
     * @param $request
     * @return bool|string
     */
    public function processMethodPOST($parameters, $request){

        try {

            $userID = (isset($parameters[0]) ? $parameters[0] : "");

            $Validator = new UserValidator();
            if($Validator->validate($request, intval($userID) > 0)){

                $id = $this->User->save($request, $userID);
                if($id){
                    $this->Response->setLastInsertID($id);
                }
                else{
                    $this->Response->setLastInsertID(0);
                    $this->Response->setErrorCode(Constants::RESPONSE_CODE_SQL_ERROR);
                    $this->Response->setMessage("Nepodařilo se uložit uživatele");
                }

            }
            else{
                $this->Response->setErrorCode(Constants::RESPONSE_CODE_VALIDATION_FAIL);
                $this->Response->setMessage($Validator->getErrors());
            }

            return $this->Response->getResponseJson();

        }
        catch(\Exception $e){

        }

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

    public function processMethodDELETE($parameters){

        $userID = (isset($parameters[0]) ? intval($parameters[0]) : 0);
        if($userID > 0) {
            $this->User->deleteUser($userID);
        }
        else{
            $this->Response->setErrorCode(Constants::RESPONSE_CODE_MISSING_PARAMETERS);
            $this->Response->setMessage("Nepodařilo se získat ID uživatele");
        }

        return $this->Response->getResponseJson();

    }

}