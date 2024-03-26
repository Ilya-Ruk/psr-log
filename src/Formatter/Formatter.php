<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

use DateTime;
use Rukavishnikov\Php\Helper\Classes\ArrayToString;
use Rukavishnikov\Psr\Log\LogMessage;

final class Formatter implements FormatterInterface
{
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    const DEFAULT_MESSAGE_FORMAT = "{date} [{level}] {message}\r\n{context}";

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
    public function formatMessage(LogMessage $message): string
    {
        $context = $this->arrayToString->convert($message->getContext());

        $result = $this->messageFormat;

        $result = str_replace('{date}', $this->dateTime->format($this->dateTimeFormat), $result);
        $result = str_replace('{level}', $message->getLevel(), $result);
        $result = str_replace('{message}', $message->getMessage(), $result);
        $result = str_replace('{context}', $context, $result);

        return $result;
    }
}
