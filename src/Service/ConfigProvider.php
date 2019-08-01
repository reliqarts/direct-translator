<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Service;

use ReliqArts\CreoleTranslator\Contract\ConfigProvider as ConfigProviderContract;

final class ConfigProvider implements ConfigProviderContract
{
    public const DIRECTORY_NAME_VOCABULARIES = 'vocabularies';

    private const RESOURCES_PATH = __DIR__ . '/../../../resources';

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
