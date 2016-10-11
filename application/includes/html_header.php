<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php echo ConfigGeneral::APPLICATION_NAME; ?></title>
<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */

use \lib\helper as Helper;

/**
 * Nacitani CSS
 */
Helper\HTML::loadCSS("bootstrap.min");
Helper\HTML::loadCSS("bootstrap-theme.min");
Helper\HTML::loadCSS("burunduk");
Helper\HTML::loadCSS("flipclock");

/**
 * Nacitani JavaScript
 */
Helper\HTML::loadJS("jquery-1.11.3.min");
Helper\HTML::loadJS("bootstrap.min");
Helper\HTML::loadJS("burunduk");
Helper\HTML::loadJS("slider");
Helper\HTML::loadJS("flipclock.min");

 ?>
