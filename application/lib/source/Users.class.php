<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 21.1.2015
 */


class Users {

    private $WebService;

    public function __construct(WebService $WebService){

        $this->WebService = $WebService;

    }

    public function loginUser($username, $password, $returnInArray = true){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/login/%s/%s', Constants::WS_URL_USERS, $username, $password);

        $result = $this->WebService->callMethod($methodURL, '', '', $returnInArray);

        if($this->WebService->getLastReturnCode() == ErrorCodes::WS_NO_ERROR){


            $result['WS_RETURN_MESSAGE'] = $this->WebService->getLastReturnCodeMsg();
            return $result;

        }
        else{

            $result['WS_RETURN_MESSAGE'] = $this->WebService->getLastReturnCodeMsg();
            return $result;

        }

    }

    /**
     * Gets locations and their currencies
     *
     * @param bool $returnInArray
     * @return string
     */
    public function getLocationsCurrency($returnInArray = true){

        $methodURL = sprintf('%s/locations', Constants::WS_URL_USERS);

        $result = $this->WebService->callMethod($methodURL, '', '', $returnInArray);

        if($this->WebService->getLastReturnCode() == ErrorCodes::WS_NO_ERROR){


            $result['WS_RETURN_MESSAGE'] = $this->WebService->getLastReturnCodeMsg();
            return $result;

        }
        else{

            $result['WS_RETURN_MESSAGE'] = $this->WebService->getLastReturnCodeMsg();
            return $result;

        }

    }

} 