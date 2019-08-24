<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Translation;

interface Formatter
{
    /**
     * @param string $inputText
     *
     * @return string
     */
    public function apply(string $inputText): string;
}
