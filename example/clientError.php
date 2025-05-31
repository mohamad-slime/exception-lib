<?php

namespace ExceptionLib;

require __DIR__ . "/../vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use ExceptionLib\CustomException;

// Set up Monolog logger and attach it to CustomException
$logger = new Logger('client');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/client.log', Logger::ERROR));
CustomException::setLogger($logger);


// Example demonstrating how to use ClientException and ExceptionFormatter
// This script simulates a client-related error and demonstrates how to format the exception details.

try {
    // Simulate client error
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://code.visualstudio.com0000/docs/languages/identifiers");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $httpError = curl_error($curl);
        $httpCode = \curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // If HTTP code is 0, it's a cURL/network error, not an HTTP response
        $errorType = $httpCode === 0 ? "cURL/network error" : 'HTTP error';

        $ex = new ClientException(
            $httpError . ($httpCode === 0 ? ' (Network/DNS error)' : ''),
            $httpCode,
            null,
            [
                'error_type' => $errorType,
                'curl_error' => $httpError,
                'http_code' => $httpCode,
                'additional_info' => [
                    'timestamp' => time(),
                ]
            ]
        );
        $ex->log();
        throw $ex;
    }
    curl_close($curl);
} catch (\Throwable $e) {
    $formatter = new ExceptionFormatter();
    echo $formatter->format($e);
}
