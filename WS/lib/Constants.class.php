<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 8:12 PM
 */

namespace lib;

class Constants
{

    const DEFAULT_RESPONSE_FORMAT = "text/plain";

    // Kazda odpoved obsahuje chybovy kod
    const RESPONSE_CODE_NO_ERROR = 0;

    // Prefixy, ktere jsou pouzity v databazi v tabulce PowerplantData pro uchovavani udaju z elektrarny
    // Napr.: Power_Actual, Temperature_Average atd
    // Po pridani nazvu prefixu budou dostupna vsechna data s timto prefixem
    const DATA_PREFIXES = array("power", "temperature");


}