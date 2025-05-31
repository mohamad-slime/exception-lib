<?php
/**
 * Class DatabaseException
 *
 * Exception thrown for database-related errors, such as query failures or connection issues.
 * Stores the query and connection name involved in the error for detailed diagnostics.
 *
 * @package Src
 */

namespace ExceptionLib;

use ExceptionLib\CustomException;

class DatabaseException extends CustomException
{
    protected ?string $query;
    protected ?string $connectionName;

    /**
     * DatabaseException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array $additionalData Additional data to attach to the exception.
     * @param string|null $query The SQL query that caused the error.
     * @param string|null $connection The database connection name.
     */
    public function __construct(
        string $message = "Database error occurred",
        int $code = 1000,
        ?\Throwable $previous = null,
        array $additionalData = [],
        ?string $query = null,
        ?string $connection = null
    ) {
        $this->query = $query;
        $this->connectionName = $connection;
        parent::__construct(
            $message,
            $code,
            $previous,
            array_merge($additionalData, [
                'type' => 'database',
                'query' => $query,
                'connection' => $connection
            ])
        );
    }

    /**
     * Get the SQL query associated with the database error.
     *
     * @return string|null The SQL query, or null if not set.
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * Get the database connection name associated with the error.
     *
     * @return string|null The connection name, or null if not set.
     */
    public function getConnectionName(): ?string
    {
        return $this->connectionName;
    }

    /**
     * Get a formatted error message including query and connection details if available.
     *
     * @return string The formatted error message.
     */
    public function getFormattedMessage(): string
    {
        $msg = $this->getMessage();
        if ($this->query) {
            $msg .= " | Query: {$this->query}";
        }
        if ($this->connectionName) {
            $msg .= " | Connection: {$this->connectionName}";
        }
        return $msg;
    }

    /**
     * Create a DatabaseException for a connection error.
     *
     * @param string|null $connectionName The database connection name.
     * @param array $additionalData Additional data to attach.
     * @param \Throwable|null $previous Previous throwable for chaining.
     * @return self
     */
    public static function connectionError(?string $connectionName = null, array $additionalData = [], ?\Throwable $previous = null): self
    {
        return new self(
            'Database connection error',
            1001,
            $previous,
            $additionalData,
            null,
            $connectionName
        );
    }

    /**
     * Create a DatabaseException for a query error.
     *
     * @param string|null $query The SQL query that caused the error.
     * @param array $additionalData Additional data to attach.
     * @param \Throwable|null $previous Previous throwable for chaining.
     * @return self
     */
    public static function queryError(?string $query = null, array $additionalData = [], ?\Throwable $previous = null): self
    {
        return new self(
            'Database query error',
            1002,
            $previous,
            $additionalData,
            $query
        );
    }
}
