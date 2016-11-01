<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 24.10.2016
 */


namespace lib;


use lib\helper\General;

class AccessControl
{

    private static $Instance = null;

    const ACCESS_ALLOW = 'allow';
    const ACCESS_DENIED = 'denied';
    private $DeniedAccess = array();

    private function __construct(){

    }

    public static function getInstance(){

        if(self::$Instance == null){
            self::$Instance = new AccessControl();
        }

        return self::$Instance;

    }

    /**
     * Prida definici pro vybranou roli, ktera nesmi na vybranou stranku
     *
     * @param $role
     * @param string $page - Stranka, kam ma $role zakazan pristup
     */
    public function addDeniedAccess($page, $role){
        if(!isset($this->DeniedAccess[$page])){
            $this->DeniedAccess[$page] = array();
        }

        $this->DeniedAccess[$page][$role] = self::ACCESS_DENIED;

    }

    /**
     * Vrati jestli ma uzivatel pristup na stranku
     * Co neni explicitne zakazano, je dovoleno
     *
     * @param $page
     * @param $role
     * @return bool
     */
    public function hasAccess($page, $role){
        $access = @$this->DeniedAccess[$page][$role];

        if(isset($access) && !empty($access)){

            return ($access == self::ACCESS_ALLOW);

        }

        return true;

    }

}