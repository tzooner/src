<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 01.11.2016
 * Time: 10:29
 */

namespace lib\helper;

class AjaxState{
    const SUCCESS = "success";
    const WARNING = "warning";
    const ERROR = "error";
}

class AjaxResponse
{

    private $State = "";
    private $Message = "";
    private $Data = array();

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * @param string $State
     */
    public function setState($State)
    {
        $this->State = $State;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * @param string $Message
     */
    public function setMessage($Message)
    {
        $this->Message = $Message;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->Data;
    }

    /**
     * @param array $Data
     */
    public function setData($Data)
    {
        $this->Data = $Data;
    }

    public function getResponseJSON(){

        $result = array(
            "STATE" => $this->getState(),
            "MESSAGE" => $this->getMessage(),
            "DATA" => $this->getData(),
        );

        return json_encode($result);

    }

}