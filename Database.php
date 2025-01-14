<?php

    class Database {

        public static $DB_USER = 'root';
        public static $DB_PASS = '';
        public static $DB_NAME = 'teste';

        /**
         * Cria uma conexão
         */
        public static function getConn($discovery = false) {
            require_once("./plugins/NotORM/NotORM.php");
            $pdo = new PDO("mysql:dbname=".self::$DB_NAME, self::$DB_USER, self::$DB_PASS);
            if( $discovery ) {
                $db = new NotORM($pdo, new NotORM_Structure_Discovery($pdo));
            } else {
                $db = new NotORM($pdo);
            }
            return $db;
        }
    }

?>