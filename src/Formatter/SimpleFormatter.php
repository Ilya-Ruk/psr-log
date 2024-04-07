<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

use Rukavishnikov\Php\Helper\Classes\ValueToStringHelper;
use Rukavishnikov\Psr\Log\LogMessage;

final class SimpleFormatter implements FormatterInterface
{
    use InterpolateContextTrait;

    /**
     * @param ValueToStringHelper $valueToStringHelper
     */
    public function __construct(
        private ValueToStringHelper $valueToStringHelper,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function formatMessage(LogMessage $logMessage): string
    {
        $message = $logMessage->getMessage();
        $context = $logMessage->getContext();

        return $this->interpolateContext($message, $context);
    }
}
