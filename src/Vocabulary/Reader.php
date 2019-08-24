<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary;

use ReliqArts\DirectTranslator\Vocabulary\Exception\ReadingFailed;

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
