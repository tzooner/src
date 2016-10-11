<h3>Seznam elektráren</h3>
<?php

$Powerplant = new \lib\source\Powerplant($WebService);

$table = \lib\source\PowerplantHTML::printTable($Powerplant->GetAllPowerPlantData());


?>

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <?php echo $table; ?>

    </div>

</div>
