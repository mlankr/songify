<?php
ob_start();
session_start();

$timezone = date_default_timezone_set(getenv('TIMEZONE'));
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
} catch (PDOException $err) {
    echo "Database connection failed. " . $err->getMessage();
    exit();
}