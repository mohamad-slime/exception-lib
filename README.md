# Exception-Lib: A PHP Exception Handling Library

[![PHP Version Support](https://img.shields.io/badge/php-^7.4|^8.0-blue)](https://www.php.net/)

Exception-Lib provides a robust set of custom exception classes and helpers to streamline error handling in PHP applications. It offers specific exception types, easy Monolog integration for logging, and convenient formatting for error reporting.

## Features

* **Collection of specific exception types**: Database, Authentication, Validation, and Client exceptions for common scenarios.
* **Monolog integration**: Effortless logging of exceptions to file or other handlers.
* **Helper functions for formatting**: Consistent, readable error messages for debugging and user feedback.
* **PSR-4 autoloading**: Modern, Composer-friendly structure.
* **Lightweight**: Minimal dependencies, easy to integrate.

## Requirements

* PHP `^7.4 || ^8.0`
* Composer
* [Monolog/monolog](https://github.com/Seldaek/monolog)

## Installation

clone the repository:

```bash
git clone https://github.com/mohamad-slime/exception-lib
cd exception-lib
composer install
```

## Usage

### Basic Example

```php
use ExceptionLib\DatabaseException;
use ExceptionLib\ExceptionFormatter;
use ExceptionLib\CustomException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Set up Monolog logger
$logger = new Logger('database');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/database.log', Logger::ERROR));
CustomException::setLogger($logger);

try {
    // Some code that may throw an exception
    throw new DatabaseException("Database connection failed.");
} catch (DatabaseException $e) {
    $e->log(); // Log the exception
    $formatter = new ExceptionFormatter();
    echo $formatter->format($e);
}
```

### Example Scripts

See the `example/` directory for ready-to-run scripts demonstrating:

* Database errors (`databaseError.php`)
* Authentication errors (`authenticationError.php`)
* Client/network errors (`clientError.php`)
* Validation errors (`validationError.php`)

Each example shows how to throw, catch, log, and format exceptions using this library.

## Directory Structure

exception-lib/
├── src/                # Library source code (exception classes, formatters)
├── example/            # Example usage scripts
├── logs/               # Log files (gitignored)
├── vendor/             # Composer dependencies
├── composer.json       # Composer config
├── README.md           # This file

## License

This project is licensed under the [MIT License](LICENSE).
