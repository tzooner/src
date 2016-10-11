<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.09.2016
 * Time: 22:43
 */

use \lib\helper\General;

// ### Parametry
$id = General::getParameter("id", "get");
$columnName = General::getParameter("column", "get");
$dateFrom = General::getParameter("dateFrom", "get");
$dateTo = General::getParameter("dateTo", "get");

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
$dateFrom_formatted = \lib\helper\DateTime::formatDate($dateFrom, "d.m.Y H:i");
$dateTo_formatted = \lib\helper\DateTime::formatDate($dateTo, "d.m.Y H:i");

// ### Odkazy pro tlacitka prepinajici rozsah dat
$actualURL = "index.php?page=powerplant&id=" . $id;
$dayRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $dayRange_from, $dayRange_to);
$weekRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $weekRange_from, $weekRange_to);
$monthRangeLink = $actualURL . sprintf("&dateFrom=%s&dateTo=%s", $monthRange_from, $monthRange_to);

// ### Obrazek grafu
$graph_image = sprintf("<img src='view/page/graphs_images/image_basicGraph.php?id=%d&dateFrom=%s&dateTo=%s%s' alt='Graf naměřených hodnot z období %s až %s'>"
    , $id, $dateFrom, $dateTo, $graphSettings, $dateFrom_formatted, $dateTo_formatted);



// ### Nacteni dat
$Powerplant = new \lib\source\Powerplant($WebService);
$dataOverview = $Powerplant->GetDataOverview($id, $dateFrom, $dateTo);
$columnsDefinition = $Powerplant->GetColumns();

// vybrane hodnoty pro zobrazeni v grafu
$detail = $Powerplant->GetPowerPlantData($id);

?>

<div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">


            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="" method="get">

                        <input type="hidden" name="page" value="powerplant"/>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                        <div class="row">
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <div class='input-group date datepicker-from'>
                                        <input type='text' class="form-control" name='dateFrom' value="<?php echo $dateFrom_formatted; ?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <div class='input-group date datepicker-to'>
                                        <input type='text' class="form-control" name='dateTo'  value="<?php echo $dateTo_formatted; ?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <?php echo \lib\source\PowerplantHTML::printValuesSelect($columnsDefinition, $selectedValues); ?>
                            </div>
                            <div class='col-md-3 text-right'>
                                <div class="form-group">
                                    <input type="submit" name="setDateRange" value="Nastavit zobrazení" class="btn btn-primary"/>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                Zobrazit data pro aktuální:
                            </div>
                            <div class="col-md-2">
                                <a href="<?php echo $dayRangeLink; ?>" class="btn btn-primary btn-xs">Den</a>
                                <a href="<?php echo $weekRangeLink; ?>" class="btn btn-primary btn-xs">Týden</a>
                                <a href="<?php echo $monthRangeLink; ?>" class="btn btn-primary btn-xs">Měsíc</a>
                            </div>
                        </div>

                    </form>

                </div>

            </div>

            <div class="row mt30">
                <div class="col-md-12">

                    <?php
                        echo $graph_image;
                    ?>

                </div>
            </div>

        </div>

</div>


<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-6">

        <?php
            echo \lib\source\PowerplantHTML::printOverview($dataOverview, $columnsDefinition);
        ?>

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">

        <?php
        echo \lib\source\PowerplantHTML::printDetail($detail);
        ?>

    </div>

</div>
