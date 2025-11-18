<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log;

use Rukavishnikov\Php\Helper\Classes\FilePath;
use Rukavishnikov\Psr\Log\Formatter\FormatterInterface;
use RuntimeException;

final class LogTargetFile implements LogTargetInterface
{
    /**
     * @param FilePath $logPath
     * @param FormatterInterface $formatter
     */
    public function __construct(
        private FilePath $logPath,
        private FormatterInterface $formatter
    ) {
    }

    /**
     * @inheritDoc
     */
    public function saveMessages(array $messages): void
    {
        if (count($messages) === 0) {
            return;
        }

        $fileFullName = $this->logPath->getFilePath();

        $fd = @fopen($fileFullName, 'a+');

        if ($fd === false) {
            throw new RuntimeException(sprintf("File '%s' open error!", $fileFullName));
        }

        if (@flock($fd, LOCK_EX) === false) {
            @fclose($fd);

            throw new RuntimeException(sprintf("File '%s' lock error!", $fileFullName));
        }

        foreach ($messages as $message) {
            $messageStr = $this->formatter->formatMessage($message);

            $result = @fwrite($fd, $messageStr);

            if ($result === false || $result !== strlen($messageStr)) {
                @flock($fd, LOCK_UN);
                @fclose($fd);

                throw new RuntimeException(sprintf("File '%s' write error!", $fileFullName));
            }
        }

        @flock($fd, LOCK_UN);
        @fclose($fd);
    }
}
