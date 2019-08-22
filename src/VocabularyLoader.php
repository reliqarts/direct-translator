<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator;

interface VocabularyLoader
{
    /**
     * @param string $key
     *
     * @throws Exception
     *
     * @return Vocabulary
     */
    public function load(string $key): Vocabulary;
}
