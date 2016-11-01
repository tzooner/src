<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.09.2016
 * Time: 20:30
 */

namespace lib\source;


use lib\Authorization;
use lib\Constants;
use lib\helper\Converter;
use lib\helper\General;
use lib\helper\Number;

class PowerplantHTML
{

    public static function printTable(array $table){

        $html = "<table class='table table-bordered'>";

        $isAdmin = Authorization::isUserAdmin();

        $actionColumns = "";
        if($isAdmin){
            $actionColumns = "<th>Editovat</th><th>Odstranit</th>";// <th>Odstranit</th>
        }

        $html .= sprintf("<thead>
                    <tr>
                        <th>Název</th>
                        <th>Popis</th>
                        <th>Město</th>
                        <th>Ulice</th>
                        %s
                        <th>Mapa</th>
                        <th>Detail</th>                        
                    </tr>
                    </thead>
                    <tbody>", $actionColumns);

        foreach ($table as $row) {

            $html .= "<tr>";

            $html .= sprintf("<td>%s</td>", $row["PowerPlantName"]);
            $html .= sprintf("<td>%s</td>", $row["Description"]);
            $html .= sprintf("<td>%s</td>", $row["City"]);
            $html .= sprintf("<td>%s</td>", $row["Street"]);

            if($isAdmin){
                $html .= sprintf("<td class='ac'><a href='index.php?page=powerplant_edit&id=%d'><span class='glyphicon glyphicon-pencil text-warning'></span></a></td>", $row["PowerPlantID"]);
                $html .= sprintf("<td class='ac'><span class='glyphicon glyphicon-remove text-danger hover remove-item' data-id='%d' data-type='powerplant'></span></td>", $row["PowerPlantID"]);
            }

            $html .= sprintf("<td class='ac'><a href='https://www.google.cz/maps/@%s,%s,15z?hl=cs' target='_blank'><span class='glyphicon glyphicon-map-marker'></span></a></td>", $row["LocationLongitude"], $row["LocationLatitude"]);
            $html .= sprintf("<td class='ac'><a href='index.php?page=powerplant&id=%d'><span class='glyphicon glyphicon-search'></span></a></td>", $row["PowerPlantID"]);

            $html .= "</tr>";

        }

        $html .= "</tbody></table>";

        return $html;

    }

    public static function printSimpleOverviewTable(array $data){

        $html =  "<table class='table table-bordered'>";
        $html .=  "<thead>
                    <tr>
                        <th>Název elektrárny</th>
                        <th>Popis</th>
                        <th>Město</th>
                        <th>Ulice</th>                        
                        <th>Mapa</th>
                        <th>Prům výkon tento týden</th>   
                    </tr>
                    </thead>
                    <tbody>";

        foreach ($data as $colName => $row) {

            $html .= "<tr>";

            $html .= sprintf("<td>%s</td>", $row["PowerPlantName"]);
            $html .= sprintf("<td>%s</td>", $row["Description"]);
            $html .= sprintf("<td>%s</td>", $row["City"]);
            $html .= sprintf("<td>%s</td>", $row["Street"]);
            $html .= sprintf("<td class='ac'><a href='https://www.google.cz/maps/@%s,%s,15z?hl=cs' target='_blank'><span class='glyphicon glyphicon-map-marker'></span></a></td>", $row["LocationLongitude"], $row["LocationLatitude"]);
            $html .= sprintf("<td>%s W</td>", Number::round($row["AVG_Power1"]));

            $html .= "</tr>";
        }

        $html .= "</tbody></table>";

        return $html;

    }

    public static function printDetail(array $row){

        $html = "<table class='table'>";

        $html .= "<tbody>";

        $html .= sprintf("<tr><th>Název</th><td>%s</td></tr>", General::isSetOrEmpty($row["PowerPlantName"]));
        $html .= sprintf("<tr><th>Popis</th><td>%s</td></tr>", General::isSetOrEmpty($row["Description"]));
        $html .= sprintf("<tr><th>Město</th><td>%s</td></tr>", General::isSetOrEmpty($row["City"]));
        $html .= sprintf("<tr><th>Ulice</th><td>%s</td></tr>", General::isSetOrEmpty($row["Street"]));
        $html .= sprintf('<tr><th>Lokace</th>
                            <td>
                                <div id="map" style="width:580px;height:300px"></div>

                                <script>
                                function myMap() {
                                  var mapCanvas = document.getElementById("map");
                                  var mapOptions = {
                                    center: new google.maps.LatLng(%s, %s),
                                    zoom: 14
                                  }
                                  var map = new google.maps.Map(mapCanvas, mapOptions);
                                }
                                </script>

                                <script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=%s"></script>
                            </td></tr>', General::isSetOrEmpty($row["LocationLongitude"]), General::isSetOrEmpty($row["LocationLatitude"]), Constants::GOOGLE_API_KEY);


        $html .= "</tbody></table>";

        return $html;

    }

    public static function printOverview($data, $columnsDefinition){

        $html = "<table class='table'>";
        $html .= "<tbody>";

        foreach ($data as $sqlName => $value) {


            $translate = Converter::powerplantDataSqlToLabel($columnsDefinition, $sqlName);
            $unit = Converter::powerplantDataSqlToUnit($sqlName);

            $html .= "<tr>";

            $html .= sprintf("<th>%s</th><td>%s %s</td>", $translate, Number::round($value), $unit);

            $html .= "</tr>";

        }

        $html .= "</tbody>";
        $html .= "</table>";

        return $html;

    }

    public static function printValuesSelect($columnsDefinition, $selectedValues){

        $html = "<select name='column[]' id='cmbColumn' class='w100p' multiple>";
        foreach ($columnsDefinition as $columnName => $title){

            $selected = "";

            if(in_array($columnName, $selectedValues)){
                $selected = "selected";
            }

            $html .= sprintf("<option value='{\"name\":\"%s\",\"value\":\"%s\"}' %s>%s</option>", $columnName, $title, $selected, $title);
        }
        $html .= "</select>";

        return $html;

    }

}