<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/19/2015
 * Time: 9:13 PM
 */

namespace lib\Script;

use lib\Constants;
use lib\Misc\Auth;
use lib\Misc\ProcessData;
use lib\validators\PowerplantValidator;

class PowerPlantScript extends Script
{

    public function __construct(){
        parent::__construct();
    }

    public function processMethodGET($parameters, $verb){

//        $username = Auth::getBasicAuthUsername();
//        $userID = $this->User->getUserIdFromUsername($username);

        if(!empty($verb)){

            switch($verb){
                case "user":    // Vrati elektrarny prirazene uzivateli
                    $userID = (isset($parameters[0]) ? $parameters[0] : "");
                    $result = $this->PowerPlant->getAllPowerPlants($userID);
                    $count = (count($result) > 0 ? 1 : 0);
                    break;
                default:
                    $result = $this->User->getAllUsers();
                    $count = count($result);

            }

            $this->Response->setData($result);
            $this->Response->setReturnedRows($count);

        }
        else {
            if (empty($parameters)) {

                $result = $this->PowerPlant->getAllPowerPlants();
                $this->Response->setData($result);
                $this->Response->setReturnedRows(count($result));

            } else {

                $powerplantID = intval($parameters[0]);

                if (isset($powerplantID) && $powerplantID > 0) {
                    $result = $this->PowerPlant->getPowerPlant($powerplantID);
                    $this->Response->setData($result);
                    $this->Response->setReturnedRows(count($result));
                } else {
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

            $powerplantID = (isset($parameters[0]) ? $parameters[0] : "");

            $Validator = new PowerplantValidator();
            if($Validator->validate($request, intval($powerplantID) > 0)){

                $id = $this->PowerPlant->savePowerPlant($request, $powerplantID);
                if($id){
                    $this->Response->setLastInsertID($id);
                }
                else{
                    $this->Response->setLastInsertID(0);
                    $this->Response->setErrorCode(Constants::RESPONSE_CODE_SQL_ERROR);
                    $this->Response->setMessage("Nepodařilo se uložit elektrárnu");
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

    public function processMethodPUT($parameters, $file)
    {
        // TODO: Implement processMethodPUT() method.
    }
}