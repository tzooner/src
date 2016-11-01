<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


class Response {

    public static function getData($input, $onlyFirstRow = false){

        if(isset($input['DATA']) && is_array($input['DATA'])){

            if($onlyFirstRow){
                if(isset($input['DATA'][0])){
                    return $input['DATA'][0];
                }
                else{
                    array();
                }
            }

            return $input['DATA'];
        }

        return array();

    }

} 