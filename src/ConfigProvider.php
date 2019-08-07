<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator;

interface ConfigProvider
{
    /**
     * @return string
     */
    public function getVocabulariesPath(): string;
}
