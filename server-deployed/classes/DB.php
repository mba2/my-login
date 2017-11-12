<?php
require_once("App.php");

final class DB extends App {

    private $iniConfig;
    private $localPath  = "/my-login/src/server/configuration/";
    private $remotePath = "/my-login/configuration/";
    


    public function __construct(){ 

        $currentPath = ($this->ENV === "development") ? $this->localPath : $this->remotePath;

        $this->iniConfig = parse_ini_file("{$_SERVER['DOCUMENT_ROOT']}{$currentPath}{$this->ENV}-db.ini");
        return $this;
    }
    
    public function connect() {
        try {
            $myPDO = new PDO("mysql:host={$this->iniConfig['host']};dbname={$this->iniConfig['dbName']}","{$this->iniConfig['userName']}","{$this->iniConfig['pass']}");         
            return $myPDO;
        } 
        catch(PDOException $pdoError){
            echo "Message: {$pdoError->getMessage()}<br>";
            echo "Code: {$pdoError->getCode()}";
        }
    }
}

?>
