<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 24.10.2016
 */


namespace lib;


class ConstantsPages
{
    // nazvy stranek, ktere jsou v URL u parametru "page"
    const URL_HOME = "home";
    const URL_POWERPLANT = "powerplant";
    const URL_POWERPLANT_NEW = "powerplant_new";
    const URL_POWERPLANT_EDIT = "powerplant_edit";
    const URL_USERS_LIST = "users";
    const URL_USERS_NEW = "user_new";
    const URL_USERS_EDIT = "user_edit";

    // nazvy souboru (bez koncovky .php), ktere odpovidaji strankam z URL
    const FILE_HOME = "page_home";
    const FILE_POWERPLANT = "page_powerplant";
    const FILE_POWERPLANT_EDIT= "page_powerplant_edit";
    const FILE_USERS_LIST = "page_users";
    const FILE_USERS_EDIT = "page_user_edit";

    const FILE_UNKNOWN = "page_home";

}
