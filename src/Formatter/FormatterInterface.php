<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

use Rukavishnikov\Psr\Log\LogMessage;

interface FormatterInterface
{
    /**
     * @param LogMessage $logMessage
     * @return string
     */
    public function formatMessage(LogMessage $logMessage): string;
}
