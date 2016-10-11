<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 30.7.2015
 */

spl_autoload_register(function ($className) {

    $file = $className . '.class.php';
//    $file = str_replace("\\", "/", $file);    // Pro linuxove stroje...
    if (file_exists($file)) {
        require_once $file;
    }

});