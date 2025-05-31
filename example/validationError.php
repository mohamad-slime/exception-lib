<?php

require __DIR__ . "/../vendor/autoload.php";

use ExceptionLib\ValidationException;
use ExceptionLib\ExceptionFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use ExceptionLib\CustomException;

// Set up Monolog logger and attach it to CustomException
$logger = new Logger('validation');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/validation.log', Logger::ERROR));
CustomException::setLogger($logger);

try {
    // Simulate form validation
    $data = ['email' => 'invalid-email'];
    // Collects all validation errors found during form validation
    $validationErrors = [];
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        // Add a descriptive error message if the email is invalid
        $validationErrors[] = 'Invalid email address format.';
    }
    if ($validationErrors) {
        // Throw ValidationException with detailed errors if any validation fails
        $ex = new ValidationException(
            'Validation failed', // Exception message
            422,                // HTTP status code for Unprocessable Entity
            null,               // No previous exception
            [
                'email' => $data['email'] // Additional data: the invalid email
            ],
            $validationErrors   // List of validation error messages
        );
        $ex->log();
        throw $ex;
    }
    // ...additional validation logic...
} catch (ValidationException $e) {
    // Format and display the exception details
    $formatter = new ExceptionFormatter();
    echo $formatter->format($e);
}
