<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 28.10.2016
 */


namespace lib\Misc;


class File
{

    private $FilePath;

    public function __construct($filePath)
    {
        $this->FilePath = $filePath;
    }

    public function writeToFile($data){
        $fh = fopen($this->FilePath, 'a') or die("can't open file");
        $data = str_replace("\n", PHP_EOL, $data);
        fwrite($fh, $data);
        fclose($fh);
    }

}