<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 21.1.2015
 */


class Authorization {

    private $Users;
    private $messages = '';
    private $WebService;

    /**
     * Permissions are divided to item (menu, pages...)
     * Every item has list of sub items (item 'menu' has sub item 'guides'...)
     */
    const PERMISSION_ITEM_MENU = 'menu';
    const PERMISSION_ITEM_PAGES = 'pages';
    const PERMISSION_ITEM_ITEMS = 'items';

    const MESSAGE_SUCCESS_LOGOUT = 1;
    const MESSAGE_URL_AUTHORIZATION_FAILED = 2;
    CONST MESSAGE_BAD_CREDENTIALS = 3;

    public function __construct(WebService $webService){

        $this->Users = new Users($webService);
        $this->WebService = $webService;

    }

    /**
     * Log user in application
     * User's data and state of login are stored in session
     * If some error occurred than is stored in variable and is accessible via getMessages()
     *
     * @param $username
     * @param $password
     */
    public function login($username, $password){

        $loginResult = $this->Users->loginUser($username, $password);

        if (isset($loginResult['RETURN_CODE']) && $loginResult['RETURN_CODE'] == ErrorCodes::WS_NO_ERROR) {

            if (isset($loginResult['DATA_TABLE']) && isset($loginResult['DATA_ROWS_COUNT'])) {

                $userData = $loginResult['DATA_TABLE'];

                // Clear all data from sessions
                unset($_SESSION['AUTHORIZATION']);

                if(count($loginResult['DATA_TABLE']) > 0) {

                    $_SESSION['AUTHORIZATION']['IS_LOGIN'] = TRUE;
                    $_SESSION['AUTHORIZATION']['USER_ID'] = $userData['_user_id'];
                    $_SESSION['AUTHORIZATION']['USERNAME'] = $username;
                    $_SESSION['AUTHORIZATION']['PASSWORD'] = $password;
                    $_SESSION['AUTHORIZATION']['FULL_NAME'] = $userData['_full_name'];
                    $_SESSION['AUTHORIZATION']['ROLE'] = $userData['_role'];
                    $_SESSION['AUTHORIZATION']['LOCATION'] = $userData['_location'];
                    $_SESSION['AUTHORIZATION']['CURRENCY'] = $userData['_currency'];

                }
                else{

                    $this->setMessageByNumber(self::MESSAGE_BAD_CREDENTIALS);

                }


            } else {

                $this->setMessageByNumber(self::MESSAGE_BAD_CREDENTIALS);

            }

        } else {

            $errorCode = $this->WebService->getLastReturnCode();

            if($errorCode == ErrorCodes::APP_BAD_URL) {
                $this->setMessageByNumber(self::MESSAGE_BAD_CREDENTIALS);   // In case of basic authentication failed
            }
            else{
                $this->setMessageByNumber(Helper::appErrorCodeTranslate($errorCode));
            }

        }

    }

    /**
     * $item is in format array('ITEM_NAME' => 'menu', 'ITEM_VALUE' => 'guides')
     *
     * @param $itemName
     * @param $itemValue
     * @return bool
     */
    public function hasPermission($itemName = self::PERMISSION_ITEM_MENU, $itemValue){

        $userRole = $this->getUserRole();

        $permissionTable = array(
                    'admin' => array(
                            'menu'=> array('guides', 'guides-find', 'guides-show', 'guide-create', 'reports', 'export-report', 'commission-report'),
                            'pages'=> array('create-guide', 'find-guides', 'detail-guide', 'show-guides', 'history-report', 'unclaimed-report', 'export-report', 'print-commission', 'print-card', 'print-qr', 'send-qr', 'commission-report', 'commission-backup'),
                            'items' => array('add-commission', 'claim-remove', 'edit-guide')
                       ),
                    'office' => array(
                            'menu'=> array('guides', 'guides-find', 'guides-show', 'guide-create'),
                            'pages'=> array('create-guide', 'find-guides', 'detail-guide', 'show-guides', 'print-commission', 'print-card', 'print-qr', 'send-qr'),
                            'items' => array('add-commission', 'edit-guide')
                       ),
                    'management' => array(
                            'menu'=> array('guides', 'guides-find', 'guides-show', 'guide-create'),
                            'pages'=> array('create-guide', 'find-guides', 'detail-guide', 'show-guides', 'print-commission', 'print-card', 'print-qr', 'send-qr'),
                            'items' => array('edit-guide')
                        ),
                    'shop' => array(
                            'menu'=> array('guides', 'guides-find', 'guides-show', 'guide-create'),
                            'pages'=> array('create-guide', 'find-guides', 'detail-guide', 'show-guides', 'print-commission'),
                            'items' => array('add-commission')
                        )
                    );

        if(isset($permissionTable[$userRole][$itemName])){

            return in_array($itemValue, $permissionTable[$userRole][$itemName]);

        }

        return false;

    }

    /**
     * Logout user
     * It is cleared $_SESSION['AUTHORIZATION'] and redirect to page index with optional message number
     */
    public function logout($messageNumber = ''){

        $urlAddition = '';
        if(!empty($messageNumber)){
            $urlAddition = '?m=' . $messageNumber;
        }

        unset($_SESSION['AUTHORIZATION']);
        header('Location: index.php' . $urlAddition);

    }

    /**
     * Return if user is log in or not
     *
     * @return bool
     */
    public function isUserLogin(){

        return (isset($_SESSION['AUTHORIZATION']['IS_LOGIN']) ? $_SESSION['AUTHORIZATION']['IS_LOGIN'] : FALSE);

    }

    /**
     * Return if user is admin
     * In database column 'is_admin'
     * It is independent on column 'role'
     *
     * @return bool
     */
    public function isUserAdmin(){

        return (isset($_SESSION['AUTHORIZATION']['ROLE']) && $_SESSION['AUTHORIZATION']['ROLE'] == 'admin' ? true : FALSE);

    }

    /**
     * Returns all user's data if they exists otherwise empty array is returned
     *
     * @return array
     */
    public function getUserData(){

        return (isset($_SESSION['AUTHORIZATION']) ? $_SESSION['AUTHORIZATION'] : array());

    }

    /**
     * Returns user's role in application
     *
     * @return string
     */
    public function getUsername(){
        return (isset($_SESSION['AUTHORIZATION']['USERNAME']) ? $_SESSION['AUTHORIZATION']['USERNAME'] : '');
    }

    /**
     * Returns user's role in application
     *
     * @return string
     */
    public function getUserRole(){
        return (isset($_SESSION['AUTHORIZATION']['ROLE']) ? $_SESSION['AUTHORIZATION']['ROLE'] : '');
    }

    /**
     * Returns user's location
     *
     * @return string
     */
    public function getUserLocation(){
        return (isset($_SESSION['AUTHORIZATION']['LOCATION']) ? $_SESSION['AUTHORIZATION']['LOCATION'] : '');
    }

    /**
     * Returns user's currency
     *
     * @return string
     */
    public function getUserCurrency(){
        return (isset($_SESSION['AUTHORIZATION']['CURRENCY']) ? $_SESSION['AUTHORIZATION']['CURRENCY'] : '');
    }

    public function getUserID(){
        return (isset($_SESSION['AUTHORIZATION']['USER_ID']) ? $_SESSION['AUTHORIZATION']['USER_ID'] : '');
    }

    public function setMessageByNumber($messageNumber){

        switch($messageNumber){
            case self::MESSAGE_SUCCESS_LOGOUT:
                $this->setMessage(Messages::printSuccessMessage('You were successfully logged out.'));
                break;
            case self::MESSAGE_URL_AUTHORIZATION_FAILED:
                $this->setMessage(Messages::printErrorMessage('Authorization failed. Try to login again.'));
                break;
            case self::MESSAGE_BAD_CREDENTIALS:
                $this->setMessage(Messages::printErrorMessage('Wrong username or password.'));
                break;
        }

    }

    public function setMessage($message){
        $this->messages = $message;
    }

    /**
     * Returns messages
     *
     * @return string
     */
    public function getMessages(){

        return $this->messages;

    }

} 