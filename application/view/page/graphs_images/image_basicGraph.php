<?php
session_start();    // Musi byt zde, protoze se zde nepouzije session_start() z indexu
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 05.10.2016
 * Time: 21:16
 */

require "../../../Config.class.php";
require "../../../autoload.php";
require "../../../includes/core.php";

$Powerplant = new \lib\source\Powerplant($WebService);

$graph = new \lib\misc\Graphs\BasicGraph('test', 'subtest');
$ImageDrawer = new \lib\misc\Graphs\ImageDrawer($graph, $Powerplant);
$ImageDrawer->draw();
