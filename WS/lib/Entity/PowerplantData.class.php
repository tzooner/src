<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 2:11 PM
 */

namespace lib\Entity;

class PowerplantData
{

    public $Power_Actual = "";
    // TODO dalsi parametry, nazvy se musi shodovat s nazvy sloupcu v DB

    public function __construct(){


    }

    /**
     * Vrati data v JSON formatu
     *
     * @return string
     */
    public function dataToJson(){

        $dataArray = array(
            "Power_Actual" => $this->Power_Actual
        );

        return json_encode($dataArray);

    }

}