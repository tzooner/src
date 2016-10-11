<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 03.10.2016
 * Time: 20:42
 */

namespace lib\misc\Graphs;


use lib\Constants;

class BasicGraph implements IGraph
{

    /**
     * Nazev grafu
     * @var string
     */
    protected $Title = "";

    protected $SubTitle = "";

    protected $FontSize = 12;


    protected $OutputPath = "";

    protected $Graph;
//    protected $LinePlot;

    public function __construct($title, $subtitle,  $graphWidth = 640, $graphHeight = 480)
    {
        $this->Title = $title;
        $this->SubTitle = $subtitle;
        $this->Graph = new \Graph($graphWidth, $graphHeight, $title);
        $this->OutputPath = \ConfigGeneral::APP_PATH . "view/tmp/";

        $this->initChart();
    }

    /**
     * @return \pData
     */
    public function getGraph()
    {
        return $this->Graph;
    }


    public function addData($legend, $dataX, $dataY = false)
    {
        $LinePlot = new \LinePlot($dataX, $dataY);
        $LinePlot->SetLegend($legend);
        $this->Graph->Add($LinePlot);
    }

    public function initChart(){

        $this->Graph->SetScale("textlin");
        $this->Graph->SetMargin(40,40,30,130);


    }

    public function draw()
    {
        $this->Graph->Stroke();

    }
}