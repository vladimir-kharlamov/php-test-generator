<?php

namespace App;

use FaaPz\PDO\Database;
use PDO;

require_once __DIR__ . '/../../vendor/autoload.php';

class myUtils {

    public static function memorySize(int $bytes)
    {
        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for ($i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++);
        return  number_format(round( $bytes, 2 ), 2, '.', ',') . " " . $label[$i];
    }

    public static function getDb() {
       
        $host = '172.25.0.2';
        $dsn = "mysql:host=$host;dbname=benchmark_test;charset=utf8mb4";
        $usr = 'root';
        $pwd = 'root';

        return (new Database($dsn, $usr, $pwd));
    }

    public static function seconds() {
        $mt = explode(' ', microtime());
        return (intval( $mt[1] * 1E3 ) + intval( round( $mt[0] * 1E3 ) )) / 1000;
    }
}