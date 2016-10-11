<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 30.7.2015
 */

/**
 * Obecne konfiguracni parametry
 * Class ConfigGeneral
 */
class ConfigGeneral {

    const APPLICATION_NAME = "Solar monitor";
    const FORMAT_DATE = "d.m.Y";
    const FORMAT_DATE_TIME = "H:i:s d.m.Y";
    const FORMAT_DATE_DATABASE = "Y-m-d";
    const DISPLAY_ERROR_MESSAGES = true;
    const APP_PATH = "C:/xampp/htdocs/solar_monitor/application/";

}

class ConfigWebservice{

    const WS_HTTP_PROTOCOL = "http";
    const WS_URL = "localhost/solar_monitor/WS/";

}

