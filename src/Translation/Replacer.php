<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Translation;

use ReliqArts\DirectTranslator\Vocabulary;

interface Replacer
{
    public const DIRECTION_LTR = 'ltr';
    public const DIRECTION_RTL = 'rtl';

    /**
     * @param string     $inputText
     * @param Vocabulary $vocabulary
     * @param string     $direction
     *
     * @return string
     */
    public function replace(
        string $inputText,
        Vocabulary $vocabulary,
        string $direction = self::DIRECTION_LTR
    ): string;
}
