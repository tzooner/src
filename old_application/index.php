<?php
session_start();
//error_reporting(1);
//ini_set('display_errors', 0);
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 29.7.2015
 */

use \lib\ConstantsPages;
use \lib\AccessControl;

require "Config.class.php";
require "autoload.php";

require "includes/core.php";


$page = \lib\helper\Security::secureGetPost("page", "get");
$pageScript = "";

$htmlError = strtolower(\lib\helper\Security::secureGetPost("err", "get"));
switch ($htmlError){
    case "access":
        $Messages->addMessageError("Nemáté oprávnění pro přístup na stránku", true);
        break;
}

//if(!$Authorization->isLoggedIn()){
//    $pageScript = "page_login";
//}
//else {

if (isset($_GET['action']) && $_GET['action'] != ''){
    $action = $_GET['action'];

    switch($action){
        case "logout":
            $Authorization->logout();
            break;
    }

}

switch ($page) {
    case ConstantsPages::URL_HOME:
        $pageScript = ConstantsPages::FILE_HOME;
        break;
    case ConstantsPages::URL_POWERPLANT:
        $pageScript = ConstantsPages::FILE_POWERPLANT;
        break;
    case ConstantsPages::URL_POWERPLANT_NEW:
        $pageScript = ConstantsPages::FILE_POWERPLANT_EDIT;
        break;
    case ConstantsPages::URL_POWERPLANT_EDIT:
        $pageScript = ConstantsPages::FILE_POWERPLANT_EDIT;
        break;
    case ConstantsPages::URL_USERS_LIST:
        $pageScript = ConstantsPages::FILE_USERS_LIST;
        break;
    case ConstantsPages::URL_USERS_NEW:
        $pageScript = ConstantsPages::FILE_USERS_EDIT;
        break;
    case ConstantsPages::URL_USERS_EDIT:
        $pageScript = ConstantsPages::FILE_USERS_EDIT;
        break;
    default:
        $pageScript = ConstantsPages::FILE_UNKNOWN;
        break;
}

// Pokud uzivatel nema na stranku pristup, tak je presmerovan na uvodni
if(!AccessControl::getInstance()->hasAccess($pageScript, $Authorization::getUserRole())) {
    \lib\helper\URL::redirect(ConstantsPages::URL_HOME, "", array("err" => "access"));
}

//}

require_once "includes/html_header.php";
require_once sprintf("view/page/%s.php", $pageScript);
require_once "includes/html_footer.php";

?>