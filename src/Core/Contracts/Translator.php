<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Core\Contracts;

interface Translator
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function translate(string $text): string;
}
