<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Contract;

interface VocabularyBuilder
{
    public const DEFAULT_LANGUAGE_CODE = 'en';

    /**
     * @param string $rawContent
     *
     * @return Vocabulary
     */
    public function createFromRawContent(string $rawContent): Vocabulary;
}
