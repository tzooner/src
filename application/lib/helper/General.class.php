<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


class General {

    /**
     * Vypocita percentualni podil mezi dvema hodnotama
     *
     * @param $value1
     * @param $value2
     * @param int $decimalPlacesRound   Pocet desetinnych mist, na ktery se ma vysledek zaokrouhlit
     * @return float|int
     */
    public static function calcShare($value1, $value2, $decimalPlacesRound = 2){

        $percentage = 0;
        if($value2 != 0){   // Ochrana, aby se nedelilo nulou...

            if($value1 == 0){   // $value2 neni nula, ale $value1 je nula => tj. stoprocentni pokles
                $percentage = 100;
            }
            else {
                $percentage = abs((1 - ($value1 / $value2))) * 100;
            }

        }
        else{

            if($value1 > 0) {

                $percentage = 100;

            }

        }

        if($value2 > $value1){
            $percentage *= (-1);
        }

        return round($percentage, $decimalPlacesRound);

    }

    /**
     * Vrati 0 pokud  je vstupni hodnota prazdna (empty) nebo null
     * @param $input
     * @return int
     */
    public static function ifNullZero($input){

        if(isset($input) && !empty($input)){
            return $input;
        }

        return 0;

    }

    public static function formatPercentage($number, $decimalPlacesRound = 2){
        $number = floatval($number);
        return round($number, $decimalPlacesRound) . "%";
    }

    /**
     * Nahradi vsechy whitespaces (v CZ?) mezerou nebo zvolenym retezcem
     *
     * @param $input
     * @param string $replaceBy
     * @return string
     */
    public static function removeWhitespaces($input, $replaceBy = " "){

        return preg_replace('/\s+/', $replaceBy, $input);

    }

    /**
     * Zobrazi logo firmy v paticce stranky vpravo
     *
     * @param string $height
     */
    public static function generateFooterLogo($height = ""){

        $heightConstraint = "";
        if($height != ""){
            $heightConstraint = sprintf("height: %dpx", $height);
        }

        echo sprintf('
            <div id="brand-logo">
                <img class="hidden-xs" src="%s" alt="" style="%s">
            </div>', \ConfigPaths::BRAND_LOGO_PATH, $heightConstraint);

    }

} 