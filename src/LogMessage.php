<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log;

final class LogMessage
{
    /**
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function __construct(
        private string $level,
        private string $message,
        private array $context
    ) {
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
