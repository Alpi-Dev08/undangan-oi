<?php
$dsn = 'mysql:host=127.0.0.1;dbname=klinik';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ';
}
