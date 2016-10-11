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

require "Config.class.php";
require "autoload.php";

require "includes/core.php";

$page = (isset($_GET["page"]) ? strtolower($_GET["page"]) : "");
$pageScript = "";

if(!$Authorization->isLoggedIn()){
    $pageScript = "page_login";
}
else {

    if (isset($_GET['action']) && $_GET['action'] != ''){
        $action = $_GET['action'];

        switch($action){
            case "logout":
                $Authorization->logout();
                break;
        }

    }

    switch ($page) {
        case "home":
            $pageScript = "page_home";
            break;
        case "powerplant":
            $pageScript = "page_powerplant";
            break;
        default:
            $pageScript = "page_home";
            break;
    }
}

require_once "includes/html_header.php";
require_once sprintf("view/page/%s.php", $pageScript);
require_once "includes/html_footer.php";

?>