<?php
/**
 * Class AuthenticationException
 *
 * Exception thrown for authentication-related errors, such as invalid credentials or unauthorized access attempts.
 * Stores the username involved in the authentication process and provides formatted error messages.
 *
 * @package Src
 */

namespace Src;

class AuthenticationException extends CustomException
{
    protected ?string $username;

    /**
     * AuthenticationException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array $additionalData Additional data to attach to the exception.
     * @param string|null $username The username involved in the authentication error.
     */
    public function __construct(
        string $message = "Authentication error occurred",
        int $code = 3000,
        ?\Throwable $previous = null,
        array $additionalData = [],
        ?string $username = null
    ) {
        $this->username = $username;
        parent::__construct(
            $message,
            $code,
            $previous,
            array_merge($additionalData, [
                'type' => 'authentication',
                'username' => $username
            ])
        );
    }

    /**
     * Get the username associated with the authentication error.
     *
     * @return string|null The username, or null if not set.
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Get a formatted error message including the username if available.
     *
     * @return string The formatted error message.
     */
    public function getFormattedMessage(): string
    {
        $msg = $this->getMessage();
        if ($this->username) {
            $msg .= " | Username: {$this->username}";
        }
        return $msg;
    }

    /**
     * Create an AuthenticationException for invalid credentials.
     *
     * @param string|null $username The username involved.
     * @param array $additionalData Additional data to attach.
     * @param \Throwable|null $previous Previous throwable for chaining.
     * @return self
     */
    public static function invalidCredentials(?string $username = null, array $additionalData = [], ?\Throwable $previous = null): self
    {
        return new self(
            'Invalid credentials provided',
            3001,
            $previous,
            $additionalData,
            $username
        );
    }

    /**
     * Create an AuthenticationException for expired tokens.
     *
     * @param string|null $username The username involved.
     * @param array $additionalData Additional data to attach.
     * @param \Throwable|null $previous Previous throwable for chaining.
     * @return self
     */
    public static function tokenExpired(?string $username = null, array $additionalData = [], ?\Throwable $previous = null): self
    {
        return new self(
            'Authentication token has expired',
            3002,
            $previous,
            $additionalData,
            $username
        );
    }
}
