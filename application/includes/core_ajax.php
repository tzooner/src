<?php
session_start();
/**
 * Jadro aplikace
 * Nacte potrebne soubory atd
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 30.7.2015
 */

use \lib\Authorization;
use \lib\webservice\URL;
use \lib\webservice\CURL;
use \lib\webservice\WebService;
use \lib\AccessControl;
use \lib\ConstantsPages;
use \lib\source\Users;

// Zasobnik zprav pro celou aplikaci
$Messages = \lib\misc\Message\MessagesStack::getInstance();

define('ROOT_DIR', str_replace("includes","",dirname(__FILE__)));
define('SESSION_ID', session_id());

$URL = new URL(ConfigWebservice::WS_HTTP_PROTOCOL, ConfigWebservice::WS_URL);

$urlUsername = '';
$urlPassword = '';

if(!empty(Authorization::getUsername()) && !empty(Authorization::getPassword())){

    $urlUsername = Authorization::getUsername();
    $urlPassword = Authorization::getPassword();

}

//$urlUsername = 'tomas';
//$urlPassword = 'heslo123';

$URL->setURL($urlUsername, $urlPassword);

$CURL = new CURL($URL->getURL());

$WebService = new WebService($CURL);

$Authorization = new Authorization($WebService);

// Vsechna ajaxova volani budou pouzivat tento objekt a vracet jen metodu $Response->getResponseJSON();
$Response = new \lib\helper\AjaxResponse();

