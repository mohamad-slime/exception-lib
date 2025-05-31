<?php

namespace ExceptionLib;

require __DIR__ . "/../vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use ExceptionLib\CustomException;

try {
    // Set up Monolog logger and attach it to CustomException
    $logger = new Logger('authentication');
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/authentication.log', Logger::ERROR));
    CustomException::setLogger($logger);

    $username = 'user@example.com';
    $password = 'wrongpassword';
    $valid = false;

    if (!$valid) {
        $ex = new AuthenticationException(
            'Invalid username or password',
            401,
            null,
            ['attempted_username' => $username],
            $username
        );
        $ex->log();
        throw $ex;
    }
} catch (\Throwable $e) {
    $formatter = new ExceptionFormatter();
    echo $formatter->format($e);
}
