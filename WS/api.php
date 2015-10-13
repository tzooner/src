<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 8:30 PM
 */

use \lib\RESTAPI\Router;

require 'autoload.php';

if(Config::IS_DEBUG){
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
}
else{
    ini_set('display_errors',0);
    ini_set('display_startup_errors',0);
    error_reporting(0);
}

try {

    $API = new Router($_REQUEST['request'], $_SERVER['REQUEST_METHOD']);
    echo $API->processAPI();

} catch (Exception $e) {

    echo json_encode(Array('error' => $e->getMessage()));

}
?>
