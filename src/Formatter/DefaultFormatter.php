<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

use DateTime;
use Rukavishnikov\Php\Helper\Classes\ValueToStringHelper;
use Rukavishnikov\Psr\Log\LogMessage;

final class DefaultFormatter implements FormatterInterface
{
    use InterpolateContextTrait;

    /**
     * @param ValueToStringHelper $valueToStringHelper
     * @param DateTime $dateTime
     * @param string $dateTimeFormat
     */
    public function __construct(
        private ValueToStringHelper $valueToStringHelper,
        private DateTime $dateTime,
        private string $dateTimeFormat = 'Y-m-d H:i:s',
    ) {
    }

    /**
     * @inheritDoc
     */
    public function formatMessage(LogMessage $logMessage): string
    {
        $message = $logMessage->getMessage();
        $context = $logMessage->getContext();

        return sprintf(
            "%s [%s] %s",
            $this->dateTime->format($this->dateTimeFormat),
            $logMessage->getLevel(),
            $this->interpolateContext($message, $context)
        );
    }
}
