<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 21.1.2015
 */

namespace lib\source;

use lib\Constants;
use lib\ErrorCodes;
use lib\helper\Response;
use lib\webservice\WebService;

class Users {

    private $WebService;

    public function __construct(WebService $WebService){

        $this->WebService = $WebService;

    }

    public function loginUser($username, $password, $returnInArray = true){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/login/%s/%s', Constants::WS_URL_USER, $username, $password);

        $result = $this->WebService->callMethod($methodURL, '', '', $returnInArray);

        return $result;

    }

} 