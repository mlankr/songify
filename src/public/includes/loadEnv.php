<?php
function loadEnv($envFilePath = null)
{
    if ($envFilePath === null) {
        $envFilePath = realpath(__DIR__."/.env");
    }

    if (file_exists($envFilePath)) {
        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if ($key !== '' && $value !== '') {
                putenv("$key=$value");
            }
        }
    } else {
        die("The .env file doesn't exist.");
    }
}

// Load environment variables from the root directory
loadEnv();