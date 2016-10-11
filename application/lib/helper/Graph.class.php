<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 11.10.2016
 */


namespace lib\helper;


use lib\Constants;
use lib\source\PowerplantColumnName;

class Graph
{

    /**
     * Prevede hodnoty, ktere vrati odeslani multiple comba pro vyber sloupcu na url pro graf
     * @param $columnFromCombo
     * @return string
     */
    public static function graphUrl($columnFromCombo){

        if(!is_array($columnFromCombo)){
            return "";
        }

        $result = "";
        foreach ($columnFromCombo as $json) {
            $column = json_decode($json, true);
            $result .= sprintf("&column[]=%s&title[]=%s", $column["name"], $column["value"]);
        }

        return $result;

    }

    /**
     * Prevede hodnoty, ktere vrati odeslani multiple comba pro vyber na pole vybranych hodnot pro vykreslovani
     * @param $columnFromCombo
     * @return string
     */
    public static function getSelectedColumns($columnFromCombo){

        $result = array();

        if(!is_array($columnFromCombo)){
            return array();
        }

        foreach ($columnFromCombo as $json) {
            $column = json_decode($json, true);
            $result[] = $column["name"];
        }

        return $result;

    }

}