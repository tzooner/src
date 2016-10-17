<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 20.09.2016
 * Time: 20:30
 */

namespace lib\source;


use lib\Constants;
use lib\helper\Converter;
use lib\helper\Number;

class PowerplantHTML
{

    public static function printTable(array $table){

        $html = "<table class='table table-bordered'>";

        $html .= "<thead>
                    <tr>
                        <th>Název</th>
                        <th>Popis</th>
                        <th>Město</th>
                        <th>Ulice</th>
                        <th>Mapa</th>
                        <th class='text-right'><a href='index.php?page=powerplant_new'><span class='glyphicon glyphicon glyphicon-plus-sign text-success' title='Přidat elektrárnu'></span></a></th>
                    </tr>
                    </thead>
                    <tbody>";

        foreach ($table as $row) {

            $html .= "<tr>";

            $html .= sprintf("<td>%s</td>", $row["PowerPlantName"]);
            $html .= sprintf("<td>%s</td>", $row["Desciption"]);
            $html .= sprintf("<td>%s</td>", $row["City"]);
            $html .= sprintf("<td>%s</td>", $row["Street"]);
            $html .= sprintf("<td><a href='https://www.google.cz/maps/@%s,%s,15z?hl=cs' target='_blank'>Mapa</a></td>", $row["LocationLongitude"], $row["LocationLatitude"]);
            $html .= sprintf("<td><a href='index.php?page=powerplant&id=%d'>Detail</a></td>", $row["PowerPlantID"]);

            $html .= "</tr>";

        }

        $html .= "</tbody></table>";

        return $html;

    }

    public static function printDetail(array $row){

        $html = "<table class='table'>";

        $html .= "<tbody>";

        $html .= sprintf("<tr><th>Název</th><td>%s</td></tr>", $row["PowerPlantName"]);
        $html .= sprintf("<tr><th>Popis</th><td>%s</td></tr>", $row["Desciption"]);
        $html .= sprintf("<tr><th>Město</th><td>%s</td></tr>", $row["City"]);
        $html .= sprintf("<tr><th>Ulice</th><td>%s</td></tr>", $row["Street"]);
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
                            </td></tr>', $row["LocationLongitude"], $row["LocationLatitude"], Constants::GOOGLE_API_KEY);


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

        $html = "<select name='column[]' id='cmbColumn' multiple>";
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