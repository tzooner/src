<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 05.10.2016
 * Time: 21:05
 */

namespace lib\Source;


class MeasurementColumn
{

    public $Index;
    public $ColumnName;
    public $RangeMin;
    public $RangeMax;
    public $DataType;

    public function __construct($index, $columnName, $rangeMin, $rangeMax, $dataType){
        $this->Index = $index;
        $this->ColumnName = $columnName;
        $this->RangeMin = $rangeMin;
        $this->RangeMax = $rangeMax;
        $this->DataType = $dataType;
    }

}