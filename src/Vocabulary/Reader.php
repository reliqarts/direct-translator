<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use ReliqArts\CreoleTranslator\Vocabulary\Exception\ReadingFailed;

interface Reader
{
    /**
     * @param string $path
     *
     * @throws ReadingFailed
     *
     * @return array
     */
    public function read(string $path): array;
}
