<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration;

use ReliqArts\CreoleTranslator\ConfigProvider\Open as OpenConfigProvider;

final class ConfigProvider extends OpenConfigProvider
{
    /**
     * @return string
     */
    public function getVocabulariesPath(): string
    {
        return __DIR__ . '/../Fixtures/vocabularies';
    }
}
