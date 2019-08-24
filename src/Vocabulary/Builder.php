<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary;

use ReliqArts\DirectTranslator\Vocabulary;
use ReliqArts\DirectTranslator\Vocabulary\Exception\InvalidContent;

interface Builder
{
    /**
     * @param array $content
     *
     * @throws InvalidContent
     *
     * @return Vocabulary
     */
    public function create(array $content): Vocabulary;
}
