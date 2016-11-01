<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 21.1.2015
 */

namespace lib;

use lib\helper\General;
use lib\helper\Response;
use \lib\webservice\WebService;
use \lib\source\Users;
use \lib\helper\URL;

class Authorization {

    private $Users;
    private $messages = '';
    private $WebService;


    const MESSAGE_SUCCESS_LOGOUT = 1;
    const MESSAGE_URL_AUTHORIZATION_FAILED = 2;
    CONST MESSAGE_BAD_CREDENTIALS = 3;

    public function __construct(WebService $webService){

        $this->Users = new Users($webService);
        $this->WebService = $webService;

    }

    public function loginUser($username, $password, $returnInArray = true){

        $dataRaw = $this->Users->loginUser($username, $password);
        $data = Response::getData($dataRaw);

        if($dataRaw["ERROR_CODE"] == ErrorCodes::WS_NO_ERROR){

            if($dataRaw['RETURNED_ROWS'] > 0){   // Prihlaseni probehlo uspesne

                $_SESSION['AUTH'] = array(
                    'logged' => true,
                    'userID' => $data["UserID"],
                    'username' => $username,
                    'password' => $password,
                    'role' => $data["RoleName"]
                );

                return true;

            }

        }

        // Nepovedlo se prihlasit
        General::clearSession('AUTH');
        return false;

    }

    public function logout($redirect = true){

        General::clearSession('AUTH');
        if($redirect){
//            header("Location: index.php?page=login&m=out");
            URL::redirect("login", "", array("m"=>"out"));
        }

    }

    public static function isLoggedIn(){
        return General::isSetOrEmpty(@$_SESSION["AUTH"]["logged"]);
    }

    public static function isUserAdmin(){
        return (strtolower(General::isSetOrEmpty(@$_SESSION["AUTH"]["role"])) == Constants::ROLE_ADMIN);
    }

    public static function getUsername(){
        return General::isSetOrEmpty(@$_SESSION["AUTH"]["username"]);
    }

    public static function getPassword(){
        return General::isSetOrEmpty(@$_SESSION["AUTH"]["password"]);
    }

    public static function getReadonlyUsername(){
        return "readonly";
    }

    public static function getReadonlyPassword(){
        return "readonly";
    }

    public static function getUserRole(){
        return General::isSetOrEmpty(@$_SESSION["AUTH"]["role"]);
    }

    public static function getUserID(){
        return General::isSetOrEmpty(@$_SESSION["AUTH"]["userID"]);
    }

} 