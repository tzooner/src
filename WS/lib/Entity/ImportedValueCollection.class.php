<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/27/2015
 * Time: 1:31 PM
 */

namespace lib\Entity;


use lib\Source\Settings;

class ImportedValueCollection
{

    private $importedValues = array();
    public function __construct(){

    }

    /**
     * Vygeneruje definici sloupcu z databaze z tabulky columnsDefinition
     * @param $powerPlantID
     */
    public function loadColumnsDefinition($powerPlantID){

        $Settings = new Settings();
        $definitions = $Settings->getColumnsDefinitions($powerPlantID);

        $index = 0;
        foreach ($definitions as $def) {
            $colName = $def["ColumnName"];
            $dataType = $def["DataType"];
            $min = $def["MinValue"];
            $max = $def["MaxValue"];
            $this->add(new ImportedValue($index, $colName, $min, $max, $dataType));
            $index++;
        }

    }

    public function add(ImportedValue $importedValue){
        $this->importedValues[$importedValue->Index] = $importedValue;
        return $this;
    }

    /**
     * @param $index
     * @return ImportedValue | null
     */
    public function get($index){

        return (isset($this->importedValues[$index]) ? $this->importedValues[$index] : null);

    }

    public function count(){
        return count($this->importedValues);
    }

    /**
     * @param string $separator
     * @return string
     */
    public function columnNamesInString($separator = ","){

        $string = "";
        foreach ($this->importedValues as $value) {
            $string .= sprintf("%s%s", $value->ColumnName, $separator);
        }
        return rtrim($string, ",");


    }

}