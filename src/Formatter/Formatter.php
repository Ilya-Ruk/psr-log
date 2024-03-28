<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

use DateTime;
use Rukavishnikov\Php\Helper\Classes\ArrayToString;
use Rukavishnikov\Psr\Log\LogMessage;
use Stringable;

final class Formatter implements FormatterInterface
{
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    const DEFAULT_MESSAGE_FORMAT = "{datetime} [{level}] {message}\r\n{context}";

    /**
     * @param DateTime $dateTime
     * @param ArrayToString $arrayToString
     * @param string $dateTimeFormat
     * @param string $messageFormat
     */
    public function __construct(
        private DateTime $dateTime,
        private ArrayToString $arrayToString,
        private string $dateTimeFormat = self::DEFAULT_DATETIME_FORMAT,
        private string $messageFormat = self::DEFAULT_MESSAGE_FORMAT
    ) {
    }

    /**
     * @inheritDoc
     */
    public function formatMessage(LogMessage $logMessage): string
    {
        $level = $logMessage->getLevel();
        $message = $logMessage->getMessage();
        $context = $logMessage->getContext();

        $arrayToString = $this->arrayToString;

        $messageStr = @preg_replace_callback(
            '/{([a-zA-Z0-9_.]+)}/',
            static function (array $matches) use ($context, $arrayToString) {
                $placeholderName = $matches[1];
                $placeholderValue = $context[$placeholderName] ?? null;

                if (is_string($placeholderValue) || ($placeholderValue instanceof Stringable)) {
                    unset($context[$placeholderName]);

                    return (string)$placeholderValue;
                } elseif (is_array($placeholderValue)) {
                    unset($context[$placeholderName]);

                    return $arrayToString->convert($placeholderValue);
                }

                return $matches[0];
            },
            $message
        );

        $dateTimeStr = $this->dateTime->format($this->dateTimeFormat);
        $contextStr = $arrayToString->convert($context);

        $result = $this->messageFormat;

        $result = str_replace('{datetime}', $dateTimeStr, $result);
        $result = str_replace('{level}', $level, $result);
        $result = str_replace('{message}', $messageStr, $result);
        $result = str_replace('{context}', $contextStr, $result);

        return $result;
    }
}
