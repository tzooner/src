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


define('ROOT_DIR', str_replace("includes","",dirname(__FILE__)));
define('SESSION_ID', session_id());

$URL = new URL(ConfigWebservice::WS_HTTP_PROTOCOL, ConfigWebservice::WS_URL);

$urlUsername = '';
$urlPassword = '';

// For the first time, we generate URL for basic authentication from POST action in logging of user
// From POST data is get username and password which is used to generate URL
// After success login is username and password get from session
if(isset($_POST['username']) && isset($_POST['password'])){

    $urlUsername = $_POST['username'];
    $urlPassword = $_POST['password'];

}
elseif(isset($_SESSION['AUTHORIZATION']['USERNAME']) && isset($_SESSION['AUTHORIZATION']['PASSWORD'])){

    $urlUsername = $_SESSION['AUTHORIZATION']['USERNAME'];
    $urlPassword = $_SESSION['AUTHORIZATION']['PASSWORD'];

}

$urlUsername = 'tomas';
$urlPassword = 'heslo123';

$URL->setURL($urlUsername, $urlPassword);

$CURL = new CURL($URL->getURL());

$WebService = new WebService($CURL);

$Authorization = new Authorization($WebService);

$messages = "";
