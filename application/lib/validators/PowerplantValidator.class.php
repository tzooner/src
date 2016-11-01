<?php

namespace lib\validators;
use lib\helper\General;

/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 24.10.2016
 */
class PowerplantValidator extends Validator
{

    public function validate($postData = array())
    {
        $name = General::isSetOrEmpty($postData["PowerPlantName"]);
        $city = General::isSetOrEmpty($postData["City"]);
        $street = General::isSetOrEmpty($postData["Street"]);
        $zip = General::isSetOrEmpty($postData["ZIP"]);

        $this->checkEmpty($name, "PowerPlantName", "Název elektrárny");
        $this->checkEmpty($city, "City", "Město");
        $this->checkEmpty($street, "Street", "Město");
        $this->checkEmpty($zip, "ZIP", "PSČ");
        $this->checkNumber($zip, "ZIP", "PSČ");

        return !$this->hasError();

    }

}