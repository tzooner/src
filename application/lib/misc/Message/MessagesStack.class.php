<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */


namespace lib\misc\Message;


class MessagesStack
{

    private static $Instance = null;

    private function __construct(){}

    /**
     * Seznam zprav
     * @var
     */
    private $Stack = array();

    public static function getInstance(){

        if(self::$Instance == null){
            self::$Instance = new MessagesStack();
        }

        return self::$Instance;

    }

    /**
     * Prida zpravu do seznamu
     * @param Message $message
     */
    public function addMessage(Message $message){
        $this->Stack[] = $message;
    }

    public function addMessageSuccess($text, $isSystem = false){
        $this->Stack[] = new Message($text, Message::TYPE_OK, $isSystem);
    }
    public function addMessageInfo($text, $isSystem = false){
        $this->Stack[] = new Message($text, Message::TYPE_INFO, $isSystem);
    }
    public function addMessageWarning($text, $isSystem = false){
        $this->Stack[] = new Message($text, Message::TYPE_WARNING, $isSystem);
    }
    public function addMessageError($text, $isSystem = false){
        $this->Stack[] = new Message($text, Message::TYPE_ERROR, $isSystem);
    }

    public function getMessagesHTML($printNotSystemMsg = true, $printSystemMsg = false){


        $html = "";
        foreach ($this->Stack as $item) {

            if($printNotSystemMsg && !$printSystemMsg && !$item->getIsSystem()){
                $msg = $item->getHTML();
            }
            else if(!$printNotSystemMsg && $printSystemMsg && $item->getIsSystem()){
                $msg = $item->getHTML();
            }
            else if($printNotSystemMsg && $printSystemMsg){
                $msg = $item->getHTML();
            }
            else{
                $msg = "";
            }

            $html .= $msg;
        }
        return $html;

    }

}