<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 11.10.2016
 */


namespace lib\misc\Graphs;


class GraphMessage
{

    public static function drawImageMessage($textToDraw){

        $font = '../../fonts/arial.ttf';
        $fontSize = 12;

        $arSize = imagettfbbox($fontSize, 0, $font, $textToDraw);
        $iWidth = abs($arSize[2] - $arSize[0]) + 20;
        $iHeight = abs($arSize[7] - $arSize[1]) + 20;

        // Set the content-type
        header('Content-Type: image/png');

        // Create the image
        $im = imagecreatetruecolor($iWidth, $iHeight);

        // Create some colors
        $white = imagecolorallocate($im, 240, 240, 240);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, $iWidth, $iHeight, $white);

        // Add the text
        imagettftext($im, $fontSize, 0, 10, $iHeight - 15, $black, $font, $textToDraw);

        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im);
        imagedestroy($im);


    }

}