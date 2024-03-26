<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log;

interface LogTargetInterface
{
    /**
     * @param LogMessage[] $messages
     * @return void
     */
    public function saveMessages(array $messages): void;
}
