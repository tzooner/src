<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 28.10.2016
 */


namespace lib\Source;


use lib\Database\DatabaseFactory;

class Role
{

    public function getAllRoles(){

        $query = "SELECT * FROM Role ORDER BY NAME";
        return @DatabaseFactory::create()->getAllRows($query);

    }

}