<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 17.10.2016
 */


namespace lib\Source;


use lib\Database\DatabaseFactory;
use lib\Helper\GeneralHelper;

class Settings
{

    /**
     * Vrati seznam sloupcu z tablky powerplantdata, kam se ukladaji namerena data, spolecne v paru s prirazenymi sloupci z tabulky columnDefinition
     *
     * @param $powerPlantID
     * @return array Asociativni pole - array("TableColumnName" => $tableColumn, "AssignedColumnName" => "");
     */
    public function getAvailablePowerplantDataColumns($powerPlantID){

        $queryAllCols = sprintf("
            SELECT 
                COLUMN_NAME                
            FROM 
                INFORMATION_SCHEMA.COLUMNS
            WHERE 
                TABLE_SCHEMA = '%s' 
                AND TABLE_NAME = 'powerplantdata' 
                AND COLUMN_NAME NOT IN ('PowerplantDataID','PowerPlantID_FK','ImportDate','CreateDate')
            ORDER BY ORDINAL_POSITION", \Config::DB_Name, $powerPlantID);

        $allColumns =  DatabaseFactory::create()->getAllRows($queryAllCols);
        $assignedCols = $this->getColumnsDefinitions($powerPlantID, false);

        $result = array();
        foreach ($allColumns as $column) {

            $tableColumn = $column["COLUMN_NAME"];

            $row = array("TableColumnName" => $tableColumn,
                        "AssignedColumnName" => "",
                        "AssignedDefinition" => "",
                        "AssignedDataType" => "",
                        "AssignedMinValue" => "",
                        "AssignedMaxValue" => "",
                        "AssignedOrder" => "",
                );

            foreach ($assignedCols as $assignedCol) {
                if($assignedCol["ColumnName"] == $tableColumn){
                    $row["AssignedColumnName"] = $assignedCol["ColumnName"];
                    $row["AssignedDefinition"] = $assignedCol["Definition"];
                    $row["AssignedDataType"] = $assignedCol["DataType"];
                    $row["AssignedMinValue"] = $assignedCol["MinValue"];
                    $row["AssignedMaxValue"] = $assignedCol["MaxValue"];
                    $row["AssignedOrder"] = $assignedCol["Order"];
                    break;
                }
            }

            $result[] = $row;

        }

        return $result;

    }

    /**
     * Vrati definici sloupcu pro elektrarnu (kazda elektrarna ma jinou definici sloupcu)
     *
     * @param $powerPlantID
     * @param bool $ignoreBool  Pokud je true, tak se ignoruji sloupce typu BOOL
     * @return array
     */
    public function getColumnsDefinitions($powerPlantID, $ignoreBool = true){

        $where = sprintf(" WHERE PowerPlantID = %d AND IFNULL(Definition, '') <> ''", $powerPlantID);//

        $query = sprintf("SELECT * FROM v_columnsDefinition %s ORDER BY `Order`", $where);
        $result = @DatabaseFactory::create()->getAllRows($query);

        if(!$ignoreBool){
            return $result;
        }

        $toReturn = array();
        foreach ($result as $row) {
            $type = strtolower($row["DataType"]);
            if($type != "bool" && $type != "boolean"){
                $toReturn[] = $row;
            }
        }

        return $toReturn;

    }

    public function saveColumnsDefinition($data){

        try {

            $powerPlantID = "";

            $sqlInsert = "";

            foreach ($data as $tableColumnName => $row) {

                $sql = "INSERT INTO columnDefinition(%s) VALUES(%s);";
                $sqlColumns = "";
                $sqlValues = "";

                foreach ($row as $columnName => $value) {

                    if(intval($powerPlantID) == 0 && $columnName == "PowerPlantID_FK"){
                        $powerPlantID = $value;
                    }

                    $value = GeneralHelper::GetValueOrNull($value);
                    $sqlColumns .= "`".$columnName . "`,";
                    $sqlValues .= $value . ",";

                }

                $sqlValues = rtrim($sqlValues,",");
                $sqlColumns = rtrim($sqlColumns,",");

                $sqlInsert .= sprintf($sql, $sqlColumns, $sqlValues);
                
            }

            // Odstrani se aktualne ulozene
            DatabaseFactory::create()->exec(sprintf("DELETE FROM columnDefinition WHERE PowerPlantID_FK = %d", $powerPlantID));

            return (DatabaseFactory::create()->exec($sqlInsert) == "1");


        }
        catch(\PDOException $e){
            return array();
        }

    }

}