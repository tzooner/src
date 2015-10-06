<?php
/**
 * Smerovani jednotlivych stranek
 * Co metoda, to stranka v URL
 * Napr.: WS/Example vola metodu example()
 *
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 8:26 PM
 */

namespace lib\RESTAPI;

use lib\Database\Database;
use lib\Database\DatabaseFactory;

class Router extends REST{

    public function __construct($request, $method){
        parent::__construct($request, $method);
    }


    public function example() {

//        echo $this->HttpMethod . "\n";
//        echo $this->Endpoint . "\n";
//        echo $this->Verb . "\n";
//        print_r($this->Parameters);

        $result = json_encode(@DatabaseFactory::create()->getAllRows("select * from testik"));

        return json_encode($this->HttpMethod);
    }

}