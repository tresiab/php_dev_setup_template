<?php

$host = 'db';
$db = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
    echo 'Database connection successful!';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
