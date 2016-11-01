<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */


namespace lib\source;


class SettingsHTML
{

    public static function printTable(array $table, $powerPlantID){

        $html = "<table class='table table-bordered'>";

        $html .= "<thead>
                    <tr>
                        <th class='col-lg-1'>Název sloupce</th>
                        <th class='col-lg-4'>Popis naměřené hodnoty</th>
                        <th class='col-lg-4'>Datový typ</th>
                        <th class='col-lg-1'>Minimální očekávaná hodnota</th>
                        <th class='col-lg-1'>Maximální očekávaná hodnota</th>
                        <th class='col-lg-1'>Pořadí v položky v importních datech</th>
                    </tr>
                    </thead>
                    <tbody>";

        foreach ($table as $row) {

            $html .= "<tr>";

            $colName = $row["TableColumnName"];

            $disabled = "";
            if($colName == "MeasurementTime") {
                $disabled = "readonly='readonly'";
                $row["AssignedDefinition"] = "Čas naměření";
                $row["AssignedDataType"] = "date";
                $row["AssignedOrder"] = "999";
            }

            $dataTypesCombo = self::getDataTypeCombo(sprintf("ColumnDefinitions[%s][DataType]", $colName), $row["AssignedDataType"], (!empty($disabled)));

            $html .= sprintf("<td>
                                <input type='hidden' name='ColumnDefinitions[%s][PowerPlantID_FK]' value='%d'/>
                                <input type='hidden' name='ColumnDefinitions[%s][ColumnName]' value='%s'/>%s
                              </td>", $colName, $powerPlantID, $colName, $colName, $colName);
            $html .= sprintf("<td><input type='text' name='ColumnDefinitions[%s][Definition]' class='form-control input-sm' value='%s' %s/></td>", $colName, $row["AssignedDefinition"], $disabled);

            $html .= sprintf("<td>%s</td>", $dataTypesCombo);
            $html .= sprintf("<td><input type='text' name='ColumnDefinitions[%s][MinValue]' class='form-control input-sm' value='%s' %s/></td>", $colName, $row["AssignedMinValue"], $disabled);
            $html .= sprintf("<td><input type='text' name='ColumnDefinitions[%s][MaxValue]' class='form-control input-sm' value='%s' %s/></td>", $colName, $row["AssignedMaxValue"], $disabled);
            $html .= sprintf("<td><input type='text' name='ColumnDefinitions[%s][Order]' class='form-control input-sm' value='%s' %s/></td>", $colName, $row["AssignedOrder"], $disabled);

            $html .= "</tr>";

        }


        $html .= "</tbody></table>";

        return $html;

    }

    public static function getDataTypeCombo($comboName, $selectedDataType = "", $isDisabled = false){

        $dataTypes = array("float" => "Desetinné číslo", "integer" => "Celé číslo", "string" => "Libovolný řetězec", "bool" => "Hodnota Ano/Ne", "date" => "Datum a čas");


        $html = sprintf("<select name='%s' class='form-control input-sm' %s>", $comboName, ($isDisabled ? "readonly='readonly'" : ""));
        $html .= "<option value='0'></option>";
        foreach ($dataTypes as $name => $description) {
            $selected = "";
            if(!empty($selectedDataType) && $selectedDataType == $name){
                $selected = "selected='selected'";
            }
            $label = sprintf("%s (%s)", $name, $description);
            $html .= sprintf("<option value='%s' title='%s' %s>%s</option>", $name, $label, $selected, $label);

        }

        $html .= "</select>";
        return $html;

    }

}