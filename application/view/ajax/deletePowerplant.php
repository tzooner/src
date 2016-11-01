<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 01.11.2016
 * Time: 10:25
 */

require_once '../../Config.class.php';
require_once '../../autoload.php';
require_once '../../includes/core_ajax.php';

$Powerplant = new \lib\source\Powerplant($WebService);

$powerplantID = \lib\helper\Security::secureGetPost("powerplantID", "get");

if(intval($powerplantID) > 0){

    if($Powerplant->DeletePowerplant($powerplantID) == \lib\ErrorCodes::WS_NO_ERROR){
        $Response->setState(\lib\helper\AjaxState::SUCCESS);
        $Response->setMessage("Uživatel byl odstraněn");
    }
    else{
        $Response->setState(\lib\helper\AjaxState::ERROR);
        $Response->setMessage("Uživatele se nepodařilo odstranit");
    }

}

echo $Response->getResponseJSON();