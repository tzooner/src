<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/27/2015
 * Time: 1:31 PM
 */

namespace lib\Entity;


class ImportedValueCollection
{

    private $importedValues = array();
    public function __construct(){

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