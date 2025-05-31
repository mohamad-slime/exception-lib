<?php
/**
 * Class ClientException
 *
 * Exception thrown for client-side errors, such as invalid requests or input from the client.
 * Stores additional context information related to the error for debugging and logging purposes.
 *
 * @package Src
 */

namespace ExceptionLib;

use ExceptionLib\CustomException;
 
class ClientException extends CustomException
{

    protected array $context;

    /**
     * ClientException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array $context Additional context information related to the error.
     */
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null, array $context = [])
    {
        parent::__construct($message, $code, $previous, $context);
        $this->context = $context;
    }

    /**
     * Get the context array associated with the client error.
     *
     * @return array The context data.
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get a formatted error message including the context if available.
     *
     * @return string The formatted error message.
     */
    public function getFormattedMessage(): string
    {
        $msg = $this->getMessage();
        if (!empty($this->context)) {
            $msg .= ' | Context: ' . json_encode($this->context);
        }
        return $msg;
    }
}
