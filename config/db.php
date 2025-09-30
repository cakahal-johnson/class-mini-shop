<?php
// database connections using PDO

//variables
$host = '127.0.0.1'; // still means localhost
$db = 'mini_shop_class';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';


// binding the vars for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // this throws exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //returns assoc arrays
    PDO::ATTR_EMULATE_PREPARES => false, // using the real prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}