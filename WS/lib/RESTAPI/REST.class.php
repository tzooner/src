<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/5/2015
 * Time: 7:49 PM
 */

namespace lib\RESTAPI;

use lib\Constants;
use lib\Helper\GeneralHelper;

abstract class REST{

    /**
     * HTTP metoda zadosti (GET, POST, PUT, DELETE)
     * @var
     */
    protected $HttpMethod;

    /**
     *
     * @var
     */
    protected $Endpoint;

    /**
     * @var
     */
    protected $Verb;

    /**
     * Doplnujici parametry
     * @var
     */
    protected $Parameters;

    protected $Request;

    /**
     * Soubor pro PUT HTTP pozadavek
     * @var
     */
    protected $File;

    protected $AllowedHttpMethod = array("GET", "POST", "DELETE", "UPDATE");

    public function __construct($request, $method){

        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: " . Constants::DEFAULT_RESPONSE_FORMAT);

        $this->Parameters = explode('/', rtrim($request, '/'));
        $this->Endpoint = array_shift($this->Parameters);
        if (array_key_exists(0, $this->Parameters) && !is_numeric($this->Parameters[0])) {
            $this->Verb = array_shift($this->Parameters);
        }
        $this->HttpMethod = $method;

        switch($this->HttpMethod) {
            case 'DELETE':
            case 'POST':
                $this->Request = $this->_cleanInputs($_POST);
                break;
            case 'GET':
                $this->Request = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->Request = $this->_cleanInputs($_GET);
                $this->File = file_get_contents("php://input");
                break;
            default:
                break;
        }

        // Metody PUT a DELETE jsou v ramci metody POST
        $postMethod = GeneralHelper::GetValueOrEmptyString(@$_SERVER['HTTP_X_HTTP_METHOD']);

        if ($this->HttpMethod == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {

            if ($postMethod == 'DELETE') {
                $this->HttpMethod = 'DELETE';
            }
            else if ($postMethod == 'PUT') {
                $this->HttpMethod = 'PUT';
            }
        }

    }

    public function processAPI() {

        // Pokud neni
        if(!$this->isHttpMethodAllowed($this->HttpMethod)){

            return $this->_response("Unknown HTTP method", 405);

        }

        if (!method_exists($this, $this->Endpoint)) {
            return $this->_response("No Endpoint: $this->Endpoint", 404);
        }

        return $this->_response($this->{$this->Endpoint}($this->Parameters));

    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return $data;
    }

    private function _cleanInputs($data) {

        $clean_input = Array();
        if (is_array($data)) {

            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }

        }
        else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    protected function isHttpMethodAllowed($method){
        $method = strtoupper($method);
        return in_array($method, $this->AllowedHttpMethod);
    }

}