<?php

namespace lib\validators;

/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 24.10.2016
 */
abstract class Validator
{

    protected $Errors = array();

    /**
     * Validuje $_POST data vrati true/false jestli je validni nebo ne
     * @param array $postData Data k validaci - nejcasteji $_POST
     * @return bool
     */
    public abstract function validate($postData = array());

    /**
     * Zkontroluje, jestli je hodnota vyplnena
     * @param $value
     * @param $formName
     * @param string $label Popis pole, ktere se zobrazi v chybove hlasce
     */
    public function checkEmpty($value, $formName, $label = ""){
        if(!isset($value) || empty($value)){
            $this->addError("Vyplňte hodnotu " . $label, $formName);
        }
    }

    /**
     * Zkontroluje, jestli je hodnota vyplnena
     * @param $value
     * @param $formName
     * @param string $label Popis pole, ktere se zobrazi v chybove hlasce
     */
    public function checkNumber($value, $formName, $label = ""){
        if(!is_numeric($value)){
            $err = sprintf("Hodnota %s není číslo", $label);
            $this->addError($err, $formName);
        }
    }

    /**
     * Vrati chybove hlasky
     * @return array
     */
    public function getErrors(){
        return $this->Errors;
    }

    /**
     * Prida chybovou hlasku
     * @param $error
     * @param $formName
     */
    protected function addError($error, $formName){
        if(!isset($this->Errors[$formName])){
            $this->Errors[$formName] = array();
        }
        $this->Errors[$formName][] = $error;
    }

    public function hasError(){
        return (count($this->getErrors()) > 0);
    }

    /**
     * Vrati naformatovane chyby v html
     */
    public function getErrorsHTML(){

        $html = "<div class='alert alert-danger'>";
        foreach ($this->getErrors() as $formErrors) {

            foreach ($formErrors as $formError) {

                $html .= sprintf("<p>%s</p>", $formError);
            }

        }

        $html .= "</div>";

        return $html;
        
    }

}