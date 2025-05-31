<?php
/**
 * Class CustomException
 *
 * Base exception class for custom exceptions in the application.
 * Allows storing additional data relevant to the exception for enhanced error reporting.
 *
 * @package Src
 */

namespace ExceptionLib;

use Monolog\Logger;

class CustomException extends \Exception
{

    protected array $additionalData;

    /**
     * @var Logger|null Monolog logger instance for logging exception details.
     */
    protected static ?Logger $logger = null;

    /**
     * CustomException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array $additionalData Additional data to attach to the exception.
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->additionalData = $additionalData;
    }

    /**
     * Get the additional data associated with the exception.
     *
     * @return array The additional data array.
     */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    /**
     * Set a Monolog logger instance to be used by all CustomException objects.
     *
     * @param Logger $logger The Monolog logger instance.
     */
    public static function setLogger(Logger $logger): void
    {
        self::$logger = $logger;
    }

    /**
     * Log the exception details using Monolog, if a logger is set.
     *
     * @param array $context Optional context data to include in the log.
     * @return void
     */
    public function log(array $context = []): void
    {
        if (self::$logger) {
            self::$logger->error($this->getMessage(), array_merge([
                'exception' => $this,
                'code' => $this->getCode(),
                'additionalData' => $this->getAdditionalData(),
            ], $context));
        }
    }
}
