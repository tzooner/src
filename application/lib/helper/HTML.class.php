<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


class HTML {

    /**
     * Nacte CSS soubor podle zadaneho jmena
     * Jmeno CSS souboru je bez koncovky!
     *
     * @param $filename
     */
    public static function loadCSS($filename){

        echo sprintf("<link href='./view/css/%s.css'  rel='stylesheet'>", $filename) . "\n";       // "\n" je jen kvuli citelnosti zdrojoveho kodu stranky

    }

    /**
     * Nacte JS soubor podle zadaneho jmena
     * Jmeno JS souboru je bez koncovky!
     *
     * @param $filename
     */
    public static function loadJS($filename){

        echo sprintf("<script type='text/javascript' src='./view/js/%s.js'></script>", $filename) . "\n";       // "\n" je jen kvuli citelnosti zdrojoveho kodu stranky

    }

} 