<?php
ob_start();
session_start();

$environment = getenv('ENVIRONMENT');
$timezone = date_default_timezone_set(getenv('TIMEZONE'));
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USERNAME');
$dbPassword = getenv('DB_PASSWORD');
$options = (strcasecmp($environment, 'PRODUCTION') === 0) ? [PDO::MYSQL_ATTR_SSL_CA => '/var/www/ssl/DigiCertGlobalRootCA.crt.pem'] : [];

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword, $options);

} catch (PDOException $err) {
    echo "Database connection failed. " . $err->getMessage();
    exit();
}