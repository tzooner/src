<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 17.10.2016
 */


namespace lib\source;

use lib\webservice\WebService;

class Source
{

    protected $WebService;

    public function __construct(WebService $WebService){

        $this->WebService = $WebService;

    }

}