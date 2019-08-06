<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator;

interface VocabularyLoader
{
    /**
     * @param string $key
     *
     * @return Vocabulary
     * @throws Exception
     */
    public function loadByKey(string $key): Vocabulary;
}
