<?php
/**
 *  Error code which are returned by API
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 14.1.2015
 */

namespace lib;

class ErrorCodes {

    /*  APPLICATION ERROR CODES*/
    const APP_NO_RETURN_CODE = -1;      // When is not possible to get return code from WS it is return -1
    const APP_JSON_PARSE_ERROR = -2;    // Returned JSON from WS error
    const APP_BAD_URL = -3;
    const APP_BAD_ID = -4;              // ID is not integer or something other is wrong with it

    /*  WS RETURN CODES*/
    const WS_NO_ERROR = 0;                     // No error occurred
    const WS_DATABASE_CONNECTION_FAILURE = 1;  // Connecting to database failed. Database is not accessible.
    const WS_DATABASE_SYSTEM_FAILURE = 2;      // Query failure. Bad database query.
    const WS_PARAMETER_MISSING = 3;            // Missing required parameter
    const WS_PARAMETER_FORMAT_ERROR = 4;       // Parameter decoding failed. Probably bad JSON string.
    const WS_RECORD_NOT_EXIST = 5;             // Calling record doesn't exists
    const WS_RECORD_CREATE_PK_ERROR = 6;       // Error on creating primary key
    const WS_AUTHORIZATION_FAILED = 7;         // Error on creating primary key
    const WS_EMAIL_FAILED = 8;
    const WS_UNKNOWN_ERROR = 99;               // Unknown error !@#$

} 