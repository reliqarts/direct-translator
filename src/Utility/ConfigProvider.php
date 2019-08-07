<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Utility;

use ReliqArts\CreoleTranslator\ConfigProvider as ConfigProviderContract;

class ConfigProvider implements ConfigProviderContract
{
    private const BASE_PATH = __DIR__ . '/../..';
    private const DIRECTORY_VOCABULARIES = 'vocabularies';
    private const DIRECTORY_RESOURCES = 'resources';

    /**
     * @return string
     */
    public function getVocabulariesPath(): string
    {
        return sprintf('%s/%s', $this->getResourcesPath(), self::DIRECTORY_VOCABULARIES);
    }

    /**
     * @return string
     */
    protected function getBasePath(): string
    {
        return self::BASE_PATH;
    }

    /**
     * @return string
     */
    protected function getResourcesPath(): string
    {
        return sprintf('%s/%s', $this->getBasePath(), self::DIRECTORY_RESOURCES);
    }
}
