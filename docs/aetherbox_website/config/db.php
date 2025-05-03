<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');    
define('DB_PASSWORD', 'kurosensei2468#KURO');        
define('DB_NAME', 'aetherbox');

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) // Catch any connection errors
{

    // kill the script and display an error message
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Return connection object
return $pdo;