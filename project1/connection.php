<?php 

class Connection {
    private static $instance;

    public static function getConn() {

        if (!isset(self::$instance)) {
            self::$instance = new PDO('mysql:host=localhost; dbname=academia_fitness', 'root', '23012007');

        }
        return self::$instance;
    }
}