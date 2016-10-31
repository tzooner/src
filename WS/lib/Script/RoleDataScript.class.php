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

class RoleDataScript extends Script
{

    public function __construct(){
        parent::__construct();
    }

    public function processMethodGET($parameters, $verb){

        if(!empty($verb)){



        }
        else{

            $result = $this->Role->getAllRoles();
            $count = count($result);

            $this->Response->setData($result);
            $this->Response->setReturnedRows($count);

        }

        return $this->Response->getResponseJson();

    }

    public function processMethodPOST($parameters, $request){


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