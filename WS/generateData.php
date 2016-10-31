<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/29/2015
 * Time: 9:50 PM
 */

function rnd(){
    return number_format((float)rand()/(float)getrandmax() * 100, 2, '.', '');
}

$startTS = time();
echo date("Y-m-d H:i:s").'<br>';
for($i = 1; $i <= 1000; $i++){

    echo sprintf("%f;%f;%f;%f;%d;%d;%d;%d;%d;%d;%d;%d;%f;%f;%d;%s", rnd(), rnd(), rnd(), rnd(), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), mt_rand(0,1), rnd(), rnd(), mt_rand(0,1), date("Y-m-d H:i:s", $startTS)) . '<br>';
    $startTS += 5;

}