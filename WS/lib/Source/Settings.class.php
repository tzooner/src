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

class Settings
{

    public function getColumnsDefinitions($powerPlantID){

        $where = "";
        if(!empty($powerPlantID)){
            $where = sprintf(" WHERE PowerPlantID = %d", $powerPlantID);
        }

        $query = sprintf("SELECT * FROM v_columnsDefinition %s ORDER BY `Order`", $where);
        return @DatabaseFactory::create()->getAllRows($query);

    }

}