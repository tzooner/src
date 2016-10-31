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
class PowerplantValidator extends Validator
{

    public function validate($postData = array(), $isEdit)
    {
        $name = GeneralHelper::GetValueOrEmptyString(@$postData["PowerPlantName"]);
        $user = GeneralHelper::GetValueOrEmptyString(@$postData["UserID_FK"]);
        $city = GeneralHelper::GetValueOrEmptyString(@$postData["City"]);
        $street = GeneralHelper::GetValueOrEmptyString(@$postData["Street"]);
        $zip = GeneralHelper::GetValueOrEmptyString(@$postData["ZIP"]);

        $this->checkEmpty($name, "PowerPlantName", "Název elektrárny");
        $this->checkEmpty($user, "UserID_FK", "Uživatel k elektrárně");
        $this->checkEmpty($city, "City", "Město");
        $this->checkEmpty($street, "Street", "Město");
        $this->checkEmpty($zip, "ZIP", "PSČ");
        $this->checkNumber($zip, "ZIP", "PSČ");

        return !$this->hasError();

    }

}