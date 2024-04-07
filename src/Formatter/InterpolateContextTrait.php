<?php

declare(strict_types=1);

namespace Rukavishnikov\Psr\Log\Formatter;

trait InterpolateContextTrait
{
    /**
     * @param string $message
     * @param array $context
     * @return string
     */
    private function interpolateContext(string $message, array &$context): string
    {
        return @preg_replace_callback(
            '/{([a-zA-Z0-9_.]+)}/',
            function (array $matches) use (&$context) {
                $placeholderName = $matches[1];

                if (array_key_exists($placeholderName, $context)) {
                    $placeholderValue = $context[$placeholderName];

                    unset($context[$placeholderName]);

                    return $this->valueToStringHelper->valueToString($placeholderValue);
                }

                return $matches[0];
            },
            $message
        );
    }
}
