<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 09.10.2016
 * Time: 18:39
 */

namespace lib\misc\Graphs;


use lib\source\Powerplant;
use lib\source\PowerplantColumnName;

class ImageDrawer
{

    protected $PowerplantData = array();
    protected $ColumnNames = array();
    /**
     * @var IGraph
     */
    protected $Graph;
    protected $Titles = array();

    public function __construct(IGraph $Graph, Powerplant $Powerplant)
    {
        $this->Graph = $Graph;
        $this->Titles = \lib\helper\General::getParameter("title", "get");

        $id = \lib\helper\General::getParameter("id", "get");
        $dateFrom = \lib\helper\General::getParameter("dateFrom", "get");
        $dateTo = \lib\helper\General::getParameter("dateTo", "get");
        $this->ColumnNames = \lib\helper\General::getParameter("column", "get");

        $columnNames = (!empty($this->ColumnNames) ? implode(",", $this->ColumnNames) : PowerplantColumnName::TEMP_AKU);
        // Nastavi se tydenni rozsah, pokud neni nastaveno datum
        $dateFrom = (!empty($dateFrom) ? $dateFrom : date('Y-m-d 00:00:00', strtotime('-7 days')));
        $dateTo= (!empty($dateTo) ? $dateTo: date('Y-m-d 23:59:59'));

        $this->PowerplantData = $Powerplant->GetPowerPlantDataInterval($id, $dateFrom, $dateTo, $columnNames);

        $this->prepareData();

    }

    private function prepareData(){

        $dataToGraph = array();

        foreach ($this->PowerplantData as $colName=>$row) {

            foreach ($this->ColumnNames as $columnName) {
                if(!isset($dataToGraph[$columnName])){
                    $dataToGraph[$columnName] = array();
                }
                @$dataToGraph[$columnName][] = $row[$columnName];
            }

        }

        $i = 0;
        foreach ($dataToGraph as $data) {

            $title = (isset($this->Titles[$i]) ? $this->Titles[$i] : "");

            $this->Graph->addData($title, $data);
            $i++;
        }

    }

    public function draw(){

        if(!empty($this->PowerplantData)){
            $this->Graph->draw();
        }
        else{
//            echo 'Žádná data pro vykreslení grafu';
            GraphMessage::drawImageMessage("Žádná data pro vykreslení grafu");
        }

    }

}