<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 17.10.2016
 */


namespace lib\source;


use lib\Constants;

class Settings extends Source
{

    public function getColumnsDefinition($powerPlantID){

        $result['WS_RETURN_MESSAGE'] = '';

        $methodURL = sprintf('%s/colDef/%d', Constants::WS_URL_SETTINGS, $powerPlantID);

        $result = $this->WebService->callMethod($methodURL);

        return $result;

    }

}