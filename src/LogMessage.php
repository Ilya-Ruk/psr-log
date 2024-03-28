<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

final class LogMessage
{
    private const LEVELS = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG,
    ];

    /**
     * @var string
     */
    private string $level;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var array
     */
    private array $context;

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function __construct(string $level, string $message, array $context)
    {
        $this->level = $this->prepareLevel($level);
        $this->message = $message;
        $this->context = $context;
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

    /**
     * @param string $level
     * @return string
     */
    private function prepareLevel(string $level): string
    {
        if (!in_array($level, self::LEVELS, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Level '%s' not supported! Level must be in ('%s').",
                    $level,
                    implode("', '", self::LEVELS)
                ),
                400
            );
        }

        return $level;
    }
}
