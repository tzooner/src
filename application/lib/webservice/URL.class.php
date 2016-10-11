<?php
/**
 * Class generate right URL to WS
 * In URL is required basic authentication but in logging we dont know username and password
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 11.2.2015
 */

namespace lib\webservice;

class URL {

    /**
     * Root of URL
     * It means without protocol and basic authentication's username and password
     *
     * @var
     */
    private $urlRoot;

    /**
     * Internet protocol (http, https)
     *
     * @var
     */
    private $protocol;

    private $URL = '';

    public function __construct($protocol, $urlRoot){

        $this->urlRoot = $urlRoot;
        $this->protocol = $protocol;

    }

    public function setURL($username, $password){

        $this->URL = sprintf('%s://%s:%s@%s', $this->protocol, $username, $password, $this->urlRoot);

    }

    public function getURL(){
        return $this->URL;
    }

} 