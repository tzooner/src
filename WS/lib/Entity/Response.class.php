<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/13/2015
 * Time: 7:38 PM
 */

namespace lib\Entity;


use lib\Constants;
use lib\Database\Database;

class Response
{

    private $ErrorCode;
    private $Data;
    private $Message;
    private $ReturnedRows;
    private $AffectedRows;
    private $LastInsertID;

    public function __construct(){}

    public function setErrorCode($errorCode){
        $this->ErrorCode = $errorCode;
    }

    public function setData(array $data){
        $result = array();
        foreach($data as $rowName => $row){
            if(is_array($row)){
                $rowResult = array();
                foreach ($row as $columnName => $item) {
                    $rowResult[$columnName] = (isset($item) ? Database::changeEncoding($item) : "");
                }
                $result[] = $rowResult;
            }
            else{
                $result[$rowName] = (isset($row) ? Database::changeEncoding($row) : "");
            }
        }
        $this->Data = $result;
        $this->ReturnedRows = count($this->Data);
    }

    public function setMessage($message){
        $this->Message = $message;
    }

    public function setReturnedRows($rows){
        $this->ReturnedRows = $rows;
    }

    public function setAffectedRows($rows){
        $this->AffectedRows = $rows;
    }

    public function setLastInsertID($id){
        $this->LastInsertID = $id;
    }

    public function getResponseJson(){

        $response = array(
            "ERROR_CODE"=>$this->ErrorCode
        );

        if(!is_null($this->ReturnedRows)){
            $response["RETURNED_ROWS"] = $this->ReturnedRows;
        }

        if(!is_null($this->AffectedRows)){
            $response["AFFECTED_ROWS"] = $this->AffectedRows;
        }

        if(!is_null($this->LastInsertID)){
            $response["LAST_INSERT_ID"] = $this->LastInsertID;
        }

        if(!is_null($this->Data)){
            $response["DATA"] = $this->Data;
        }

        if(!is_null($this->Message)){
            $response["MESSAGE"] = $this->Message;
        }

        $json = json_encode($response);
        if(json_last_error() != JSON_ERROR_NONE){
            return sprintf('JSON convert error (%s)', json_last_error_msg());
        }
        return $json;

    }

}