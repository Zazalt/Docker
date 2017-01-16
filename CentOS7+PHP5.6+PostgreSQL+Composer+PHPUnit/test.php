<?php

echo 'Current PHP version: '. phpversion() ."\n";

if(!class_exists('PDO')) {
    echo 'PDO class does not exists';
} else {
    foreach (PDO::getAvailableDrivers() as $driver) {
        echo $driver . "\n";
    }

    $dsn = "pgsql:host=localhost;port=5432;dbname=test";
    try {
        $connection = new \PDO($dsn, 'test', 'test');
        echo ($connection) ? 'Connected' : 'Not connected';
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
        // TODO: continue
    }
}