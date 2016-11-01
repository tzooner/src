<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.09.2016
 * Time: 22:43
 */

use \lib\helper\URL;
use \lib\helper\DateTime;
use \lib\source\Powerplant;

// ### Parametry
$PowerPlantID = intval(URL::getParameter("id", "get"));
$columnName = URL::getParameter("column", "get");
$dateFrom = URL::getParameter("dateFrom", "get");
$dateTo = URL::getParameter("dateTo", "get");

// ### Nastaveni grafu
$selectedValues = \lib\helper\Graph::getSelectedColumns($columnName);
$graphSettings = \lib\helper\Graph::graphUrl($columnName);

// ### Vygenerovani datumovych rozsahu
$dayRange_from = date("Y-m-d 00:00:00");
$dayRange_to = date("Y-m-d 23:59:00");

$weekRange_from = date('Y-m-d 00:00:00', strtotime('monday this week'));
$weekRange_to = date('Y-m-d 23:59:00', strtotime('sunday this week'));

$monthRange_from = date('Y-m-01 00:00:00');
$monthRange_to = date('Y-m-t 23:59:00');

if(empty($dateFrom) || empty($dateTo)){
    $dateFrom = $weekRange_from;
    $dateTo = $weekRange_to;
}

// Naformatovane datum pro uzivatelske rozhrani
$actualDateFrom_formatted = DateTime::formatDate($dateFrom, "d.m.Y H:i");
$dateTo_formatted = DateTime::formatDate($dateTo, "d.m.Y H:i");

// ### Odkazy pro tlacitka prepinajici rozsah dat
$actualURL = "index.php?page=powerplant&id=" . $PowerPlantID;
$dayRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $dayRange_from, $dayRange_to);
$weekRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $weekRange_from, $weekRange_to);
$monthRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $monthRange_from, $monthRange_to);

// ### Obrazek grafu
$graph_image = sprintf("<img src='view/page/graphs_images/image_basicGraph.php?id=%d&dateFrom=%s&dateTo=%s%s' alt='Graf naměřených hodnot z období %s až %s'>"
    , $PowerPlantID, $dateFrom, $dateTo, $graphSettings, $actualDateFrom_formatted, $dateTo_formatted);



// ### Nacteni dat
$Powerplant = new Powerplant($WebService);
$dataOverview = $Powerplant->GetDataOverview($PowerPlantID, $dateFrom, $dateTo);
$columnsDefinition = $Powerplant->GetColumns($PowerPlantID);

// vybrane hodnoty pro zobrazeni v grafu
$detail = $Powerplant->GetPowerPlantData($PowerPlantID);

?>

<div class="row mb15">
    <div class="col-lg-12 text-right">
        <a href="<?php echo URL::getActualURL() . "&export=pdf"; ?>" class="btn btn-warning btn-xs">Exportovat do PDF</a>
    </div>
</div>

<div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">


            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="" method="get" id="frmSetGraph" style="margin: 0">

                        <input type="hidden" name="page" value="powerplant"/>
                        <input type="hidden" name="id" value="<?php echo $PowerPlantID; ?>"/>

                        <div class="row">

                            <div class="col-lg-7 col-md-6 col-sm-6">

                                <div class="row" style="margin-bottom: 8px">

                                    <div class="col-lg-6 col-md-4 text-right">
                                        Nastavit rozsah:
                                    </div>
                                    <div class="col-lg-6 col-md-8">
                                        <button type="button" class="btn btn-info btn-xs btn-set-date" data-date-from="<?php echo DateTime::formatDateTime($dayRange_from);?>" data-date-to="<?php echo DateTime::formatDateTime($dayRange_to);?>">Aktuální den</button>
                                        <button type="button" class="btn btn-info btn-xs btn-set-date" data-date-from="<?php echo DateTime::formatDateTime($weekRange_from);?>" data-date-to="<?php echo DateTime::formatDateTime($weekRange_to);?>">Aktuální týden</button>
                                        <button type="button" class="btn btn-info btn-xs btn-set-date" data-date-from="<?php echo DateTime::formatDateTime($monthRange_from);?>" data-date-to="<?php echo DateTime::formatDateTime($monthRange_to);?>">Aktuální měsíc</button>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <div class='input-group date datepicker-from'>
                                                <input type='text' class="form-control" name='dateFrom' id="dateFrom" value="<?php echo $actualDateFrom_formatted; ?>"/>
                                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <div class='input-group date datepicker-to'>
                                                <input type='text' class="form-control" name='dateTo' id="dateTo"  value="<?php echo $dateTo_formatted; ?>"/>
                                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6">

                                <div class="row">

                                    <div class="col-lg-7 col-md-7 text-right">
                                        <?php echo \lib\source\PowerplantHTML::printValuesSelect($columnsDefinition, $selectedValues); ?>
                                    </div>
                                    <div class="col-lg-5 col-md-5 text-right">
                                        <input type="submit" name="setDateRange" value="Nastavit zobrazení" class="btn btn-primary btn-sm"/>
                                    </div>

                                </div>

                            </div>


                        </div>


                    </form>

                </div>

            </div>

            <div class="row mt30">
                <div class="col-lg-8 col-md-8 col-sm-12 text-center">

                    <div class="panel panel-success minh">

                        <div class="panel-heading">
                            Graf naměřených hodnot
                        </div>

                        <div class="panel-body">
                            <?php
                            echo $graph_image;
                            ?>
                        </div>

                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 text-center">

                    <div class="panel panel-success minh">

                        <div class="panel-heading">
                            Přehled naměřených údajů
                        </div>

                        <div class="panel-body">
                            <?php
                            echo \lib\source\PowerplantHTML::printOverview($dataOverview, $columnsDefinition);
                            ?>
                        </div>

                    </div>

                </div>
            </div>

        </div>

</div>


<div class="row">

    <div class="col-lg-8 col-md-8 col-sm-12">

        <div class="panel panel-info">
            <div class="panel-heading">
                Informace o elektrárně
                <?php
                if(\lib\Authorization::isUserAdmin()){
                    echo sprintf('<a href="index.php?page=powerplant_edit&id=%d"><span class="glyphicon glyphicon-pencil text-warning pull-right"></span></a>', $PowerPlantID);
                }
                ?>
            </div>
            <div class="panel-body">

                <?php
                echo \lib\source\PowerplantHTML::printDetail($detail);
                ?>

            </div>
        </div>

    </div>

</div>
