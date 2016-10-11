<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 05.10.2016
 * Time: 21:04
 */

namespace lib\Source;

use lib\Constants;

class Measurement
{

    private static $Instance = null;

    private $columnsSetup = array();

    private function __construct()
    {

        $this->add(new MeasurementColumn(0, "Temp_AKU", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(1, "Temp_BoilerInput", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(2, "Temp_DistributionInput", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(3, "Temp_Boiler", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(4, "Relay_BoilerPump", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(5, "Relay_RadiatorPump", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(6, "Relay_SwitchAKU", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(7, "Relay_SwitchBoiler", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(8, "Relay_BoilerFlow1", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(9, "Relay_BoilerFlow2", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(10, "Relay_PumpFromBoiler", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(11, "Relay_BoilerHeating", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(12, "Performance_Drive", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(13, "Performance_Network", 0, 100, Constants::IMPORT_DATA_TYPE_FLOAT))
            ->add(new MeasurementColumn(14, "Other_Optocoupler", 0, 1, Constants::IMPORT_DATA_TYPE_BOOL))
            ->add(new MeasurementColumn(15, "MeasurementTime", 0, 100, Constants::IMPORT_DATA_TYPE_STRING));

    }

    public static function instance(){

        if(self::$Instance == null){
            self::$Instance = new Measurement();
        }

        return self::$Instance;

    }

    public function add(MeasurementColumn $importedValue){
        $this->columnsSetup[$importedValue->Index] = $importedValue;
        return $this;
    }

    /**
     * @param $index
     * @return MeasurementColumn | null
     */
    public function get($index){

        return (isset($this->importedValues[$index]) ? $this->importedValues[$index] : null);

    }

    public function count(){
        return count($this->importedValues);
    }

}