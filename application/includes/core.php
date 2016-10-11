<?php
/**
 * Jadro aplikace
 * Nacte potrebne soubory atd
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 30.7.2015
 */

define('ROOT_DIR', str_replace("includes","",dirname(__FILE__)));
define('SESSION_ID', session_id());

require_once ROOT_DIR . "Config.class.php";
require_once ROOT_DIR . "autoload.php";

use lib\model as Model;