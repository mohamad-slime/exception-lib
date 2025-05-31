<?php
/**
 * Class ExceptionFormatter
 *
 * Formats exceptions into readable string representations for logging or displaying error information.
 * Implements the ExceptionFormatterInterface to ensure consistent formatting across the application.
 *
 * @package Src
 */

namespace Src;


class ExceptionFormatter implements ExceptionFormatterInterface
{
    /**
     * Format the given exception as a readable string.
     *
     * @param \Throwable $exception The exception to format.
     * @return string The formatted exception string.
     */
    public function format(\Throwable $exception): string
    {
        $data = ($exception instanceof CustomException) ? $exception->getAdditionalData() : [];
        $dataString = $data ? json_encode($data, JSON_PRETTY_PRINT) : 'None';
        return sprintf(
            "Error: %s\nCode: %d\nFile: %s:%d\nAdditional Data: %s",
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            $dataString
        );
    }
}
