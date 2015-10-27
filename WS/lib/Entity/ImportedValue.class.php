<?php
/**
 * Entitni trida
 * Enita importovanych udaju
 *
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/27/2015
 * Time: 1:26 PM
 */

namespace lib\Entity;


class ImportedValue
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