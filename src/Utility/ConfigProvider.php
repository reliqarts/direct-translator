<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Utility;

class ConfigProvider
{
    private const DIRECTORY_NAME_VOCABULARIES = 'vocabularies';
    private const RESOURCES_PATH = __DIR__ . '/../../../Resources';

    /**
     * @return string
     */
    public function getResourcesPath(): string
    {
        return self::RESOURCES_PATH;
    }

    /**
     * @return string
     */
    public function getVocabulariesPath(): string
    {
        return sprintf('%s/%s', $this->getResourcesPath(), self::DIRECTORY_NAME_VOCABULARIES);
    }
}
