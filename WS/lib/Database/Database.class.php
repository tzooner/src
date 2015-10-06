<?php
/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 10/6/2015
 * Time: 11:33 AM
 */

namespace lib\Database;


abstract class Database{

    protected $Hostname;
    protected $DbName;
    protected $Username;
    protected $Password;
    /**
     * Instance PDO
     * @var \PDO
     */
    protected $PDO;

    /**
     * Informace, jestli se behem scriptu vyskytla chyba
     *
     * @var
     */
    protected $HasError;
    protected $LastErrorMsg = array();

    protected function __construct($hostname, $dbName, $username, $password, $dbType){
        $this->Hostname = $hostname;
        $this->DbName = $dbName;
        $this->Username = $username;
        $this->Password = $password;

        $connectionString = sprintf("%s:host=%s;dbname=%s", $dbType, $hostname, $dbName);

        try {
            $this->PDO = new \PDO($connectionString, $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\PDOException $ex){
            echo "Connection error: " . $ex->getMessage();
            exit;
        }

    }

    public static function getInstance(){}

    /**
     * Vrati vsechna data z databaze
     *
     * @param string $query         SQL dotaz
     * @param array $parameters     PDO parametry
     * @return array
     */
    public function getAllRows($query, array $parameters = array())
    {

        if(!$this->HasError) {

            try {

                $prepare = $this->PDO->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                $prepare->execute($parameters);

                if (!$prepare) {
                    $error = $this->PDO->errorInfo();
                    echo $error[2];
                } else {

                    return $prepare->fetchAll(\PDO::FETCH_ASSOC);
                }

            } catch (\PDOException $ex) {

                $this->handleError($ex);
                echo "Query error: " . $ex->getMessage();

            }

        }

        return array();


    }

    /**
     * Vrati data z databaze, ale jen prvni radek
     *
     * @param string $query         SQL dotaz
     * @param array $parameters     PDO parametry
     * @return array                Asociativni pole, kde indexy odpovidaji nazvum sloupcu v databazi
     */
    public function getOneRow($query, array $parameters = array())
    {

        if(!$this->HasError) {
            try{

                $prepare = $this->PDO->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                $prepare->execute($parameters);

                if (!$prepare) {
                    $error = $this->PDO->errorInfo();
                    echo $error[2];
                }
                else {

                    return $prepare->fetch(\PDO::FETCH_ASSOC);
                }

            }
            catch(\PDOException $ex){

                $this->handleError($ex);
                echo "Query error: " . $ex->getMessage();

            }
        }

        return array();

    }

    /**
     * Provedeni prikazu DML (insert, update)
     *
     * @param string $query         SQL dotaz
     * @param array $parameters     PDO parametry
     * @return int                  Pocet ovlivnenych radku
     */
    public function exec($query, array $parameters = array())
    {

        if(!$this->HasError) {
            try {

                $prepare = $this->PDO->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                $prepare->execute($parameters);

                if (!$prepare) {
                    $error = $this->PDO->errorInfo();
                    echo $error[2];
                } else {

                    return $prepare->rowCount();
                }

            } catch (\PDOException $ex) {

                $this->handleError($ex);
                echo "Query error: " . $ex->getMessage();

            }
        }

        return 0;

    }

    /**
     * Zpracovani chyboveho stavu PDO
     *
     * @param \PDOException $ex
     */
    protected function handleError(\PDOException $ex){

        if($ex->getCode() != 0){

            $this->HasError = 1;
            $this->LastErrorMsg = $ex->getMessage();

        }
    }

}