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

class Roles {

    const ROLE_ADMIN = "admin";
    const ROLE_USER = "user";

    private $WebService;

    public function __construct(WebService $WebService){

        $this->WebService = $WebService;

    }

    public function getAllRoles(){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = Constants::WS_URL_ROLE;

        $result = $this->WebService->callMethod($methodURL);

        return Response::getData($result);

    }

} 