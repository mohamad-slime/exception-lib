<?php
/**
 * Interface ExceptionFormatterInterface
 *
 * Defines a contract for formatting exceptions into string representations.
 * Ensures that all exception formatters implement a consistent format method.
 *
 * @package Src
 */

namespace Src;

interface ExceptionFormatterInterface
{
    /**
     * Format the given exception as a string.
     *
     * @param \Throwable $exception The exception to format.
     * @return string The formatted exception string.
     */
    public function format(\Throwable $exception): string;
}
