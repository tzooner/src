<?php

namespace lib\misc\Graphs;

require_once \ConfigGeneral::APP_PATH."lib/vendor/jpgraph/jpgraph.php";
require_once \ConfigGeneral::APP_PATH."lib/vendor/jpgraph/jpgraph_line.php";
require_once \ConfigGeneral::APP_PATH."lib/vendor/jpgraph/jpgraph_date.php";
require_once \ConfigGeneral::APP_PATH.'lib/vendor/jpgraph/jpgraph_utils.inc.php';

/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 03.10.2016
 * Time: 20:40
 */
interface IGraph
{

    public function draw();
    public function addData($legend, $dataX, $dataY = false);

}