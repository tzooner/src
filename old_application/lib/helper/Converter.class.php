<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 11.10.2016
 */


namespace lib\helper;


class Converter
{

    /**
     * Preklad nazvu sloupce dat z SQL tabulky powerplantdata na nazvy
     *
     * @param $columnsDefinition
     * @param $sqlName
     * @return mixed
     */
    public static function powerplantDataSqlToLabel($columnsDefinition, $sqlName){

        $split = explode("_", $sqlName);
        $prefix = strtoupper(array_shift($split));
        $sqlName = implode("_", $split);   // Bez prefixu AVG, MAX atd

        $translation = (isset($columnsDefinition[$sqlName]) ? $columnsDefinition[$sqlName] : $sqlName);


        $prefixName = $prefix;
        switch ($prefix){
            case "AVG":
                $prefixName = "Průměrná";
                break;
            case "MIN":
                $prefixName = "Nejmenší";
                break;
            case "MAX":
                $prefixName = "Nejvyšší";
                break;
        }

        $result = sprintf("%s %s", $prefixName, lcfirst($translation));

        return $result;

    }

    /**
     * Preklad nazvu sloupce dat z SQL tabulky powerplantdata na jednotky
     * @param $sqlName
     * @return string
     */
    public static function powerplantDataSqlToUnit($sqlName){

        $parse = explode("_", $sqlName);

        $unitRaw = (isset($parse[1]) ? $parse[1] : "");
        switch(strtolower($unitRaw)){
            case "temp":
                $unit = "°C";
                break;
            case "performance":
                $unit = "W";
                break;
            default:
                $unit = "";
        }

        return $unit;

    }

}