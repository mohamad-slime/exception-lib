<?php

namespace ExceptionLib;

require __DIR__ . "/../vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Example demonstrating how to use DatabaseException and ExceptionFormatter with PDO
// This script attempts to run a query on a non-existing table to trigger a PDOException,
// then wraps it in a DatabaseException and formats the output.

// Set up Monolog logger and attach it to CustomException
$logger = new Logger('database');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/database.log', Logger::ERROR));
CustomException::setLogger($logger);

// Example usage
try {
    // Create a PDO connection to the MySQL database
    $pdo = new \PDO('mysql:host=localhost;dbname=myapp', 'user', 'password');
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    // Simulate a database query that will fail
    $stmt = $pdo->query('SELECT * FROM non_existing_table');
} catch (\Throwable $e) {
    // Prepare query and connection info for the custom exception
    $query = 'SELECT * FROM non_existing_table';
    $connection = 'mysql:host=localhost;dbname=myapp';

    // Wrap the PDOException in a DatabaseException, including additional context
    $dbException = new DatabaseException(
        $e->getMessage(),
        $e->getCode(),
        $e,
        [
            'query' => [
                'sql' => $query
            ],
            'connection' => [
                'dsn' => $connection,
                'database' => 'myapp'
            ]
        ],
        $query,
        $connection
    );
    // Format and display the exception details
    // This will also log the exception details using Monolog
    $dbException->log();
    $formatter = new ExceptionFormatter();
    echo $formatter->format($dbException);
}
