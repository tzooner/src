<?php

// Pro neprihlaseneho uzivatele se zobrazuje jen jednoduchy prehled vsech elektraren
$isLoggedIn = \lib\Authorization::isLoggedIn();

$addButton = "";
$Powerplant = new \lib\source\Powerplant($WebService);

if($isLoggedIn) {

    if (\lib\Authorization::isUserAdmin()) {
        $addButton = "<a href='index.php?page=powerplant_new'><span class='glyphicon glyphicon glyphicon-plus-sign text-success' title='Přidat elektrárnu' style='font-size: 30px'></span></a>";
    }

    $table = \lib\source\PowerplantHTML::printTable($Powerplant->GetAllPowerPlant());

}
else{

    $weekRange_from = date('Y-m-d 00:00:00', strtotime('-7 days'));
    $weekRange_to = date('Y-m-d 23:59:00');

    $table = \lib\source\PowerplantHTML::printSimpleOverviewTable($Powerplant->GetDataSimpleOverview($weekRange_from, $weekRange_to));

}

?>
<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-8">

        <h3>Seznam elektráren</h3>

    </div>
    <div class="col-lg-6 col-md-6 col-sm-4 text-right">

        <?php
        echo $addButton;
        ?>

    </div>

</div>
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <?php
        echo $table;
        ?>

    </div>

</div>
