<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/19/2015
 * Time: 9:53 PM
 */

namespace lib\Misc;


use lib\Constants;
use lib\Entity\ImportedValue;
use lib\Entity\ImportedValueCollection;
use lib\Database\DatabaseFactory;
use lib\Source\PowerplantData;

class ProcessData
{

    private $Path;

    protected $PowerPlantID;

    private $columnsSetup;
    private $importErrorsLog;
    private $importWarningLog;

    public function __construct($powerPlantID, $path, $fileName){

        $this->PowerPlantID = $powerPlantID;
        $this->checkPath($path);
        $this->Path = $path . $fileName;

        $this->columnsSetup = new ImportedValueCollection();
        $this->columnsSetup->loadColumnsDefinition($this->PowerPlantID);

    }

    public function saveToFile($data){

        //file_put_contents($this->Path, $data); // nefunguje na savane...
        $fh = fopen($this->Path, 'a') or die("can't open file");
        $data = str_replace("\n", PHP_EOL, $data);
        fwrite($fh, $data);
        fclose($fh);

    }

    public function importToDatabase(){

        $importDate = "";
        $handle = fopen($this->Path, "r");
        $insertQueryValues = "";
        if ($handle) {

            $lineNr = 1;
            while (($line = fgets($handle)) !== false) {

                // Prvni radek je datum
                if($lineNr == 1){
                    $importDate = $line;
                }
                else{

                    $insertQueryValues .= $this->generateMysqlInsertValues($line, $lineNr, $this->PowerPlantID, $importDate);

                }

                $lineNr++;
            }

            fclose($handle);
        } else {
            // error opening the file.
        }

        $insertQueryValues = rtrim($insertQueryValues, ",");

        $columns = sprintf("PowerPlantID_FK, %s", $this->columnsSetup->columnNamesInString());

        $query = sprintf("INSERT INTO PowerplantData(%s) VALUES %s", $columns, $insertQueryValues);

        $importedRows = 0;
        try {
            $importedRows = @DatabaseFactory::create()->exec($query);
        }
        catch(\PDOException $e){
            $this->addImportError("SQL chyba pri importu: " . $e->getMessage());
        }

        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $PowerPlantData = new PowerplantData();
        $PowerPlantData->saveImportLog($importDate, $importedRows, $this->getImportErrors(), $this->getImportWarnings(), $ipAddress);

    }

    /**
     * Metoda vygeneruje hodnoty pro vlozeni do databaze v databazovem formatu
     * Generuje se jen cast SQL dotazu - insert into xxx() values(TOTO SE GENERUJE)
     *
     * @param string $line  - jeden radek dat, data jsou oddelena oddelovacem definovanym v Config::FILE_SEPARATOR
     * @param int $lineNr   - cislo radku
     * @param $powerPlantID - ID elektrarny, pro kterou jsou volana data
     * @param $importDate   - Datum importovanych dat, datum se bere z importovanych dat
     * @return string
     */
    private function generateMysqlInsertValues($line, $lineNr, $powerPlantID, $importDate){

        // Odstraneni znaku pro novy radek
        //$line = preg_replace('/\s+/', '', $line);

        $items = explode(\Config::FILE_SEPARATOR, $line);

        $insertPart = "";


        if(count($items) == $this->columnsSetup->count()-1) {
            foreach ($items as $itemIndex => $itemValue) {

                $columnSetup = $this->columnsSetup->get($itemIndex);

                // Nastaveni pro sloupec musi byt definovano
                if (!is_null($columnSetup)) {

                    // Importovana hodnota je v povolenem rozmezi hodnot
                    if ($columnSetup->DataType != Constants::IMPORT_DATA_TYPE_STRING && ($itemValue < $columnSetup->RangeMin || $itemValue > $columnSetup->RangeMax)) {

                        $err = sprintf("\"%s\" je pro \"%s\" mimo rozsah", $itemValue, $columnSetup->ColumnName);
                        $this->addImportWarnings($err);

                    }

                    switch ($columnSetup->DataType) {
                        case Constants::IMPORT_DATA_TYPE_BOOL:
                            $insertPart .= ($itemValue == 1 || $itemValue == "true" || $itemValue == true ? 1 : 0) . ',';
                            break;
                        case Constants::IMPORT_DATA_TYPE_FLOAT:
                            $insertPart .= sprintf("%f,", $itemValue);
                            break;
                        case Constants::IMPORT_DATA_TYPE_INT:
                            $insertPart .= sprintf("%d,", $itemValue);
                            break;
                        case Constants::IMPORT_DATA_TYPE_STRING:
                            $insertPart .= sprintf("'%s',", $itemValue);
                            break;
                        case Constants::IMPORT_DATA_TYPE_DATE:
                            $insertPart .= sprintf("'%s',", $itemValue);
                            break;
                    }

                } else {
                    $this->addImportError("Chybejici nastaveni pro sloupec s indexem " . $itemIndex);
                }

            }

            $insertPart = rtrim($insertPart, ",");
            $insertPart = sprintf("(%d, %s, '%s'),", $powerPlantID, $insertPart, $importDate);

        }
        else{

            $this->addImportError(sprintf("Pocet udaju na radku %d neodpovida nastaveni", $lineNr));
            $insertPart = "";

        }


        return $insertPart;

    }

    private function addImportError($errorText){

        $this->importErrorsLog .= $errorText . "||";

    }

    private function addImportWarnings($warningText){

        $this->importWarningLog .= $warningText . "||";

    }

    public function getImportErrors(){
        return $this->importErrorsLog;
    }

    public function getImportWarnings(){
        return $this->importWarningLog;
    }

    private function checkPath($path){
        if(!file_exists($path)){
            mkdir($path);
        }
    }

}