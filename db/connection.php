<?php

$dns = "mysql:host=localhost;port=3306;dbname=calculator_user;charset=utf8mb4";
$username = "root";
$password = "admin1234";

// NOTE: Change above configuration according to your mysql credentials.

$pdo = new PDO($dns, $username, $password, [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

return $pdo;

