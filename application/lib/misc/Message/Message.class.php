<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */


namespace lib\misc\Message;


class Message
{

    const TYPE_OK = "success";
    const TYPE_INFO = "info";
    const TYPE_WARNING = "warning";
    const TYPE_ERROR = "danger";

    private $Text;
    private $Type;
    // Systemove zpravy se zobrazuji na vsech strankach - zprava se generuje v html_header.php
    private $IsSystem;

    /**
     * Message constructor.
     * @param $Text
     * @param $Type
     * @param $IsSystem
     */
    public function __construct($Text, $Type, $IsSystem)
    {
        $this->Text = $Text;
        $this->Type = $Type;
        $this->IsSystem = $IsSystem;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->Text;
    }

    /**
     * @param mixed $Text
     */
    public function setText($Text)
    {
        $this->Text = $Text;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getIsSystem()
    {
        return $this->IsSystem;
    }

    /**
     * @param mixed $IsSystem
     */
    public function setIsSystem($IsSystem)
    {
        $this->IsSystem = $IsSystem;
    }

    /**
     * Vrati css tridu pro prislusny typ zpravy
     * @return mixed
     */
    public function getTypeHTML(){

        switch(strtolower($this->Type)){
            case self::TYPE_OK: // Prozatim hodnoty konstant odpovidaji nazvu trid z bootstrap, ale v budoucnu se muzou lisit...
            case self::TYPE_INFO:
            case self::TYPE_WARNING:
            case self::TYPE_ERROR:
                return $this->Type;
        }
    }

    public function getHTML(){

        return sprintf("<div class='alert alert-%s'>%s</div>", $this->getTypeHTML(), $this->getText());

    }

}