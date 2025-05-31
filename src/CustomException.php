<?php
/**
 * Class CustomException
 *
 * Base exception class for custom exceptions in the application.
 * Allows storing additional data relevant to the exception for enhanced error reporting.
 *
 * @package Src
 */

namespace Src;

class CustomException extends \Exception
{

    protected array $additionalData;

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
}
