<?php
<<<<<<< HEAD
namespace root_dev\Config;
=======

>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f

define('DB_HOST', 'localhost');
define('DB_NAME', 'framework');
define('DB_USER', 'root');
define('DB_PASS', '');

class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            try {
<<<<<<< HEAD
                self::$pdo = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
=======
                self::$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
                die("Could not connect to the database: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function close() {
        self::$pdo = null;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
