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

    const APPLICATION_NAME = "Burunduk by Memos";
    const FORMAT_DATE = "d.m.Y";
    const FORMAT_DATE_TIME = "H:i:s d.m.Y";
    const FORMAT_DATE_DATABASE = "Y-m-d";
    const DISPLAY_ERROR_MESSAGES = true;

}

class ConfigApplication{

    // Pocet dni o kolik zpet se ma zobrazovat statistika (grafy)
    const GRAPH_STATISTICS_BACK_DAYS = 7;
    const LEADES_DISPLAY_PEOPLE = 10;

}

class ConfigPaths{

    // Cesty musi koncit musi koncit "/" !!!

    // Absolutni cesta k aplikaci
    const APPLICATION_PATH = "C:/xampp/htdocs/Burunduk/";
    // Cesta k logu na spodni strane slidu
    const BRAND_LOGO_PATH = "view/images/slides/logo.png";
    // Cesta ke slozce s docasnymi soubory
    const TEMP_PATH = "view/tmp/";
    // Cesta ke knihovnam tretich stran
    const VENDOR_PATH = "lib/vendor/";
    // Cesta ke slozce, kde jsou uchovavany slidy
    const SLIDES_PATH = "view/slides/";
    // Cesta a nazev LOG souboru
    const LOG_FILE = "LOG.txt";

}


/**
 * Konfiguracni parametry databaze
 *
 * Class ConfigDatabase
 */
class ConfigDatabase{

    // TODO odstranit jen testovaci
    const BURUNDUK_HOST = "localhost";
    const BURUNDUK_USERNAME = "root";
    const BURUNDUK_PASSWORD = "";
    const BURUNDUK_DATABASE = "burunduk";
    const BURUNDUK_DB_TYPE = "mysql";

//    const BURUNDUK_HOST = "redmine";
//    const BURUNDUK_USERNAME = "burunduk";
//    const BURUNDUK_PASSWORD = "chIPmunk";
//    const BURUNDUK_DATABASE = "burunduk";
//    const BURUNDUK_DB_TYPE = "mysql";

    const REDMINE_HOST = "redmine";
    const REDMINE_USERNAME = "burunduk";
    const REDMINE_PASSWORD = "chIPmunk";
    const REDMINE_DATABASE = "redmine";
    const REDMINE_DB_TYPE = "mysql";

    const SOBOL_HOST = "sobol";
    const SOBOL_USERNAME = "PHP_READER";
    const SOBOL_PASSWORD = "Memos951";
    const SOBOL_DATABASE = "Pohoda2eWay";
    const SOBOL_DB_TYPE = "mssql";

    const EWAY_HOST = "ewayserver";
    const EWAY_USERNAME = "PHP_READER";
    const EWAY_PASSWORD = "Memos951";
    const EWAY_DATABASE = "eWay3_Memos_LIVE";
    const EWAY_DB_TYPE = "mssql";

}