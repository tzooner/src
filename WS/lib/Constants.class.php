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
    const RESPONSE_CODE_MISSING_PARAMETERS = 1;
    const RESPONSE_CODE_VALIDATION_FAIL = 2;
    const RESPONSE_CODE_SQL_ERROR = 3;

    const EXEC_STATE_SUCCESS = "success";
    const EXEC_STATE_ERROR = "error";

    // Datove typy importovanych hodnot
    const IMPORT_DATA_TYPE_INT = "int";
    const IMPORT_DATA_TYPE_FLOAT = "float";
    const IMPORT_DATA_TYPE_BOOL = "bool";
    const IMPORT_DATA_TYPE_STRING = "string";
    const IMPORT_DATA_TYPE_DATE = "date";

}