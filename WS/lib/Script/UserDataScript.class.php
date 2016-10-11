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

            $result = $this->User->getAllUsers();
            $count = count($result);

            $this->Response->setData($result);
            $this->Response->setReturnedRows($count);

        }

        return $this->Response->getResponseJson();

    }

    public function processMethodPOST($parameters, $verb, $request){

//        if(!empty($verb)){
//
//            switch($verb){
//                case "login":
//                    $username = (isset($parameters[0]) ? $parameters[0] : "");
//                    $password = (isset($parameters[1]) ? $parameters[1] : "");
//                    $result = $this->User->loginUser($username, $password);
//                    $count = (count($result) > 0 ? 1 : 0);
//                    break;
//                default:
//                    $result = $this->User->getAllUsers();
//                    $count = count($result);
//
//            }
//
//            $this->Response->setData($result);
//            $this->Response->setReturnedRows($count);
//
//        }

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