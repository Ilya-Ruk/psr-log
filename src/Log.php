<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;

final class Log implements LoggerInterface
{
    use LoggerTrait;

    /** @var LogMessage[] $messages */
    private array $messages = [];

    /**
     * @param LogTargetInterface $logTarget
     */
    public function __construct(
        private LogTargetInterface $logTarget
    ) {
        register_shutdown_function(function () {
            $this->saveMessages();
        });
    }

    /**
     * @inheritDoc
     */
    public function log(mixed $level, string|Stringable $message, array $context = []): void
    {
        $this->messages[] = new LogMessage($level, $message, $context);
    }

    /**
     * @return void
     */
    private function saveMessages(): void
    {
        $this->logTarget->saveMessages($this->messages);
    }
}
