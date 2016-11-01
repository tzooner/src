<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 19.1.2015
 */

namespace lib\webservice;

class CURL {

    const REQUEST_TYPE_POST = "POST";
    const REQUEST_TYPE_PUT = "PUT";
    const REQUEST_TYPE_DELETE = "DELETE";

    protected $_userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
    protected $_url;
    protected $_followLocation;
    protected $_timeout;
    protected $_maxRedirects;
    protected $_post;
    protected $_postFields;
    protected $_ssl = 0;

    protected $_session;
    protected $_webpage;
    protected $_includeHeader;
    protected $_status;
    public    $authentication = 0;
    public    $auth_name      = '';
    public    $auth_pass      = '';

    public function __construct($hostURL, $followlocation = true, $timeOut = 30,$maxRedirecs = 4, $includeHeader = false)
    {
        $this->_url = $hostURL;
        $this->_followLocation = $followlocation;
        $this->_timeout = $timeOut;
        $this->_maxRedirects = $maxRedirecs;
        $this->_includeHeader = $includeHeader;

    }

    public function useAuth($use){
        $this->authentication = 0;
        if($use == true) $this->authentication = 1;
    }

    public function setName($name){
        $this->auth_name = $name;
    }
    public function setPass($pass){
        $this->auth_pass = $pass;
    }

    public function setReferer($referer){
        $this->_referer = $referer;
    }

    public function setSSL($ssl = 0){
        $this->_ssl = $ssl;
    }


    public function setPostData($postFields)
    {
        $this->_post = true;
        $this->_postFields = $postFields;
    }

    public function setUserAgent($userAgent)
    {
        $this->_userAgent = $userAgent;
    }

    public function createCurl($url, $requestType = '', $data = ''){

        $s = curl_init();

        if($url != ''){
            $curlURL = $this->_url . $url;
        }
        else{
            return;
        }

        if($requestType != ''){
            curl_setopt($s,CURLOPT_CUSTOMREQUEST, $requestType);
        }

        curl_setopt($s,CURLOPT_POST, false);

        if($data != ''){
            curl_setopt($s,CURLOPT_POST, true);
            curl_setopt($s,CURLOPT_POSTFIELDS, http_build_query($data));    // http_build_query rozlozi vicedimenzionalni pole na string
        }

        curl_setopt($s,CURLOPT_URL, $curlURL);
//        curl_setopt($s,CURLOPT_HTTPHEADER,array("Content-type: multipart/form-data"));
        curl_setopt($s,CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($s,CURLOPT_MAXREDIRS, $this->_maxRedirects);
        curl_setopt($s,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s,CURLOPT_FOLLOWLOCATION, $this->_followLocation);
        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, $this->_ssl);

        if($this->authentication == 1){
            curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
        }

        if($this->_includeHeader)
        {
            curl_setopt($s,CURLOPT_HEADER,true);
        }

        curl_setopt($s,CURLOPT_USERAGENT,$this->_userAgent);

        $this->_webpage = curl_exec($s);
        $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);

        curl_close($s);

    }

    public function getHttpStatus()
    {
        return $this->_status;
    }

    public function getPage(){
        return $this->_webpage;
    }

} 