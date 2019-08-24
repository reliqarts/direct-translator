<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Translation\Formatter;

use ReliqArts\DirectTranslator\Translation\Formatter;

final class SentenceCase implements Formatter
{
    private const PATTERN = '/([.!?])\s*(\w)/';

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function apply(string $inputText): string
    {
        $str = ucfirst(strtolower($inputText));

        return preg_replace_callback(
            self::PATTERN,
            function ($matches) {
                return strtoupper($matches[0]);
            },
            $str
        );
    }
}
