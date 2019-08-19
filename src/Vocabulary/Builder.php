<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use ReliqArts\CreoleTranslator\Vocabulary;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\InvalidContent;

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
