<?php

    class Database{

        public function __construct(
           private string $host,
           private string $name,
           private string $user,
           private string $password
        ){

        }

        public function getConnection(): PDO{
            $sdn = "mysql:host={$this->host}; dbname={$this->name}; charset=utf8";
            // return new PDO('mysql:host=localhost;dbname=flower_db', 'root', '');
            
            return new PDO($sdn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                
                // CASO OS INTEGERS APARECEM COMO "STRING"
                // PDO::ATTR_EMULATE_PREPARES => false,
                // PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        }
    }
?>