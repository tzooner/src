<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 3.8.2015
 */


namespace lib\helper;


use lib\ErrorCodes;

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

    public static function getMessage($input, $onlyFirstRow = false){

        if(isset($input['MESSAGE'])){

            if($onlyFirstRow){
                if(isset($input['MESSAGE'][0])){
                    return $input['MESSAGE'][0];
                }
                else{
                    array();
                }
            }

            return $input['MESSAGE'];
        }

        return array();

    }

    public static function getInsertedId($input){

        if(isset($input['LAST_INSERT_ID'])){
            return $input['LAST_INSERT_ID'];
        }
        else{
            array();
        }

    }

    public static function getErrorCode($input){

        if(isset($input['ERROR_CODE'])){
            return $input['ERROR_CODE'];
        }
        return ErrorCodes::WS_UNKNOWN_ERROR;

    }

} 