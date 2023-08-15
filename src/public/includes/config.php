<?php
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("EUROPE/BERLIN");

    try {
        $pdo = new PDO('mysql:host=songify-mysql;dbname=songify', 'songify', 'computer33');
    } catch (PDOException $err) {
        echo "Database connection failed. " . $err->getMessage();
        exit();
    }
