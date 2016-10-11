<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/19/2015
 * Time: 9:14 PM
 */

namespace lib\Script;


use lib\Constants;
use lib\Entity\Response;
use lib\Source\PowerplantData;
use lib\source\User;

abstract class Script{

    protected $Response;
    protected $PowerPlantData;
    protected $User;

    public function __construct(){
        $this->Response = new Response();
        $this->Response->setErrorCode(Constants::RESPONSE_CODE_NO_ERROR);
        $this->PowerPlantData = new PowerplantData();
        $this->User = new User();
    }

    public abstract function processMethodGET($parameters, $verb);
    public abstract function processMethodPUT($parameters, $file);

    public function clearResponse(){
        $this->Response = null;
    }
    
}