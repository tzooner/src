<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


class DateTime {

    /**
     * Naformatuje vstupni datum do formatu datumu pouzivaneho v cele aplikaci
     *
     * @param $input
     * @param string $format   Format datumu na vystup
     * @return bool|string
     */
    public static function formatDate($input, $format = \ConfigGeneral::FORMAT_DATE){
        if(empty($input)) return "";
        return date($format, strtotime($input));
    }
    /**
     * Naformatuje vstupni datum a cas do formatu datumu a casu pouzivaneho v cele aplikaci
     * @param $input
     * @return bool|string
     */
    public static function formatDateTime($input){
        return date(\ConfigGeneral::FORMAT_DATE_TIME, strtotime($input));
    }

    /**
     * Vrati aktualni obdobi - rok a mesic ve formatu "Ym"
     *
     * @return bool|string
     */
    public static function getActualMonthPeriod(){
        return date("Ym");
    }

    /**
     * Vrati obdobi z minuleho mesice - rok a mesic ve formatu "Ym"
     *
     * @return bool|string
     */
    public static function getPreviousMonthPeriod(){
        return date("Ym",strtotime("-1 month"));
    }

    /**
     * Vrati aktualni datum v databazovem tvaru
     *
     * @return bool|string
     */
    public static function getActualDateDatabaseFormat(){
        return date(\ConfigGeneral::FORMAT_DATE_DATABASE);
    }

    /**
     * Vrati vcerejsi datum v databazovem tvaru
     *
     * @return bool|string
     */
    public static function getYesterdayDateDatabaseFormat(){
        return date(\ConfigGeneral::FORMAT_DATE_DATABASE, strtotime("-1 day"));
    }

    /**
     * Vrati predvcerejsi datum v databazovem tvaru
     *
     * @return bool|string
     */
    public static function getTwoDaysBackDateDatabaseFormat(){
        return date(\ConfigGeneral::FORMAT_DATE_DATABASE, strtotime("-2 day"));
    }

    /**
     * Vrati datum prvniho dne aktualniho mesice
     *
     * @return string
     */
    public static function getActualMonthFirstDayDate(){
        return date("Y-m-") . "1";
    }

    /**
     * Vrati datum posledniho dne aktualniho mesice
     *
     * @return bool|string
     */
    public static function getActualMonthLastDayDate(){
        return date("Y-m-t");
    }

    /**
     * Vrati datum prvniho dne predchoziho mesice
     *
     * @return string
     */
    public static function getPreviousMonthFirstDayDate(){
        return date("Y-m-", strtotime("-1 month")) . "1";
    }

    /**
     * Vrati datum posledniho dne predchoziho mesice
     *
     * @return bool|string
     */
    public static function getPreviousMonthLastDayDate(){
        return date("Y-m-t", strtotime("-1 month"));
    }

    /**
     * Vrati nazev aktualniho mesice
     *
     * @param string $date  Pokud neni vyplneno, vrati nazev aktualniho mesice
     * @return bool|string
     */
    public static function getMonthName($date = ""){

        if(empty($date)) {
            return date("F");
        }
        else{
            return date("F", strtotime($date));
        }
    }

    /**
     * Vygeneruje retezec datumu pro sloupce PIVOTu
     *
     * @param $startDate
     * @param $backDays
     * @return string
     */
    public static function generatePivotLastDates($startDate, $backDays){

        $result = "";
        for($i = --$backDays; $i >= 0; $i--){

            $result .= sprintf("[%s],", date("Y-m-d", strtotime('-'.$i.' day', strtotime($startDate))));

        }

        $result = rtrim($result, ",");

        return $result;

    }

    /**
     * Vygeneruje pole s datumy od datumu $startDate o $backDays dni zpet
     *
     * @param $startDate
     * @param $backDays
     * @return string
     */
    public static function generateLastDates($startDate, $backDays){

        $result = array();
        for($i = --$backDays; $i >= 0; $i--){

            $result[] = date(\ConfigGeneral::FORMAT_DATE, strtotime('-'.$i.' day', strtotime($startDate)));

        }

        return $result;

    }

    /**
     * Vygeneruje pole s cisly mesicu
     *
     * @return array
     */
    public static function generateMonthsNumberToArray(){

        $months = array();
        for($i = 1; $i <= 12; $i++){
            $months[] = $i;
        }

        return $months;

    }

    /**
     * Vrati aktualni pocet sekund do zadaneho datumu
     *
     * @param $toDate
     * @return float
     */
    public static function getSecondsToDate($toDate){

        $actualTime = strtotime('now');
        $endDate = strtotime($toDate);
        return round($endDate - $actualTime);

    }

    /**
     * Vrati true pokud je vlozene datum poslednim dnem mesice
     *
     * @param $date
     * @return bool
     */
    public static function isLastDayInMonth($date){

        $lastMonthDate = date("Y-m-t", strtotime($date));

       return ($lastMonthDate == $date);

    }

} 