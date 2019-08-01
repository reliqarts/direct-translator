<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Contract;

interface ConfigProvider
{
    /**
     * @return string
     */
    public function getResourcesPath(): string;

    /**
     * @return string
     */
    public function getVocabulariesPath(): string;
}
