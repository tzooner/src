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

$User = new \lib\source\Users($WebService);

$userID = \lib\helper\Security::secureGetPost("userID", "get");

if(intval($userID) > 0){

    if($User->DeleteUser($userID) == \lib\ErrorCodes::WS_NO_ERROR){
        $Response->setState(\lib\helper\AjaxState::SUCCESS);
        $Response->setMessage("Uživatel byl odstraněn");
    }
    else{
        $Response->setState(\lib\helper\AjaxState::ERROR);
        $Response->setMessage("Uživatele se nepodařilo odstranit");
    }

}

echo $Response->getResponseJSON();