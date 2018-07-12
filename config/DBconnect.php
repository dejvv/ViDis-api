<?php
class DBconnect {

    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    private static $schema = "diagenkri";
    private static $instance = null;

    /**
     * Returns a PDO instance -- a connection to the database.
     * The singleton instance assures that there is only one connection active
     * at once (within the scope of one HTTP request)
     *
     * @return PDO instance
     */
    public static function connect() {
        if (!self::$instance) {
            $config = "mysql:host=" . self::$host
                . ";dbname=" . self::$schema;
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            );
            try {
                self::$instance = new PDO($config, self::$user, self::$password, $options);
            } catch (PDOException $e) {
                echo 'Connection error: ' . $e->getMessage(); 
            }
        }
        return self::$instance;
    }
}