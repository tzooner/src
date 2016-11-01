<?php
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

// For the first time, we generate URL for basic authentication from POST action in logging of user
// From POST data is get username and password which is used to generate URL
// After success login is username and password get from session
if(isset($_POST['btnLogin'])){

    $urlUsername = $_POST['txtUsername'];
    $urlPassword = $_POST['txtPassword'];

}
elseif(!empty(Authorization::getUsername()) && !empty(Authorization::getPassword())){

    $urlUsername = Authorization::getUsername();
    $urlPassword = Authorization::getPassword();

}
else if(!Authorization::isLoggedIn()){
    $urlUsername = Authorization::getReadonlyUsername();
    $urlPassword = Authorization::getReadonlyPassword();
}
$URL->setURL($urlUsername, $urlPassword);

$CURL = new CURL($URL->getURL());

$WebService = new WebService($CURL);

$Authorization = new Authorization($WebService);

AccessControl::getInstance()->addDeniedAccess(ConstantsPages::FILE_POWERPLANT_EDIT, Users::ROLE_USER);
AccessControl::getInstance()->addDeniedAccess(ConstantsPages::FILE_USERS_LIST, Users::ROLE_USER);
AccessControl::getInstance()->addDeniedAccess(ConstantsPages::FILE_USERS_EDIT, Users::ROLE_USER);
