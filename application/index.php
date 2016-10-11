<?php
session_start();    // Potrebne - na zaklade session ID se generuji treba nazvy souboru
//error_reporting(1);
//ini_set('display_errors', 0);
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 29.7.2015
 */

require 'includes/core.php';

$presentationKey = \lib\helper\Security::secureGetPost("key", "get");

$Slide = new \lib\source\Slide($presentationKey);

?>
<!DOCTYPE html>
<html>

    <head>
        <?php require 'includes/html_header.php'; ?>
    </head>
    <body>

        <?php
        if(empty($presentationKey)){
            $presentations = $Slide->getActivePresentationKeysString();
            $message = sprintf("Je potřeba zadat do URL klíč prezentace. Dostupné prezentace: <strong>%s</strong>", $presentations);
            \lib\entity\MessagesStorage::getInstance()->addMessage(new \lib\entity\Message($message , \lib\entity\MessageType::ERROR));
            echo \lib\entity\MessagesStorage::getInstance()->getMessagesHTML();
            exit;
        }
        ?>

        <div id="header">
<!--            Hlavička-->
            <div id="offline-info">
                <img src="view/images/disconnected.png"/>
            </div>
        </div>

        <input type="hidden" id="presentationKey" value="<?php echo $presentationKey;?>">
        <!-- Vsechny nactene slidy -->
        <div id="slides" data-reload-period="">

            <?php

                \lib\helper\Slide::loadAllSlidesHTML($presentationKey);

            ?>

        </div>


        <!--            Patička-->
        <div id="footer">

            <div class="slide-pagination"></div>

        </div>

    </body>

</html>

<?php
// Zalogovani pripadnych chyb do souboru
\lib\entity\MessagesStorage::getInstance()->logErrorMessages();
?>