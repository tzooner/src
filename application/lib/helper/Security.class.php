<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 30.7.2015
 */

namespace lib\helper;

class Security {

    /**
     * Bezpecne ziskani GET/POST parametru
     *
     * @param $field
     * @param $type
     * @return string
     */
    public static function secureGetPost($field,$type){

        switch($type) {
            case 'get':
                $output = filter_input(INPUT_GET, $field, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                break;
            case 'post':
                $output = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                break;
            default:
                $output = "";
                break;
        }

        return $output;
    }

} 