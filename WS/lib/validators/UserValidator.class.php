<?php

namespace lib\validators;
use lib\helper\General;
use lib\Helper\GeneralHelper;

/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 24.10.2016
 */
class UserValidator extends Validator
{

    public function validate($postData = array(), $isEdit)
    {
        $username = GeneralHelper::GetValueOrEmptyString(@$postData["Username"]);
        $password = GeneralHelper::GetValueOrEmptyString(@$postData["Password"]);
        $email = GeneralHelper::GetValueOrEmptyString(@$postData["Email"]);
        $role = GeneralHelper::GetValueOrEmptyString(@$postData["RoleID_FK"]);

        $this->checkEmpty($username, "Username", "Uživatelské jméno");
        if(!$isEdit) {
            $this->checkEmpty($password, "Password", "Heslo");
        }
        $this->checkEmpty($email, "Email", "E-mail");
        $this->checkEmpty($role, "RoleID_FK", "Role");

        return !$this->hasError();

    }

}