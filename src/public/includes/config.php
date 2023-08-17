<?php
ob_start();
session_start();

/* TODO: Fetch env variables*/
//$timezone = date_default_timezone_set(getenv('TIMEZONE_LOCAL'));
//$dbHost = getenv('DOCKER_CONTAINER_DB');
//$dbName = getenv('DB_NAME');
//$dbUser = getenv('DB_USERNAME');
//$dbPassword = getenv('DB_PASSWORD');

$timezone = date_default_timezone_set("EUROPE/BERLIN");

try {
//    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
//    $pdo = new PDO('mysql:host=songify-mysql;dbname=songify', 'songify', 'songify33');
    $pdo = new PDO('mysql:host=milans-songify-webapp-server.mysql.database.azure.com;dbname=milans-songify-webapp-database', 'mjnltdqzww', 'RZM270OCI0A5145P$');
} catch (PDOException $err) {
    echo "Database connection failed. " . $err->getMessage();
    exit();
}