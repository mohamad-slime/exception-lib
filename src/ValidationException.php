<?php
/**
 * Class ValidationException
 *
 * Exception thrown for validation errors, such as invalid input data or failed business rules.
 * Stores an array of validation errors for detailed error reporting and debugging.
 *
 * @package Src
 */

namespace Src;

class ValidationException extends CustomException
{
    protected array $validationErrors;

    /**
     * ValidationException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array $additionalData Additional data to attach to the exception.
     * @param array $validationErrors The array of validation errors.
     */
    public function __construct(
        string $message = "Validation error occurred",
        int $code = 2000,
        ?\Throwable $previous = null,
        array $additionalData = [],
        array $validationErrors = []
    ) {
        $this->validationErrors = $validationErrors;
        parent::__construct(
            $message,
            $code,
            $previous,
            array_merge($additionalData, [
                'type' => 'validation',
                'errors' => $validationErrors
            ])
        );
    }

    /**
     * Get the array of validation errors associated with the exception.
     *
     * @return array The validation errors.
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * Get a formatted error message including validation errors if available.
     *
     * @return string The formatted error message.
     */
    public function getFormattedMessage(): string
    {
        $msg = $this->getMessage();
        if ($this->validationErrors) {
            $msg .= " | Errors: " . implode(", ", $this->validationErrors);
        }
        return $msg;
    }

    /**
     * Create a ValidationException from an array of errors.
     *
     * @param array $errors The validation errors.
     * @param \Throwable|null $previous Previous throwable for chaining.
     * @return self
     */
    public static function fromErrors(array $errors, ?\Throwable $previous = null): self
    {
        return new self(
            'Validation errors occurred',
            2001,
            $previous,
            [],
            $errors
        );
    }
}
