<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration;

use ReliqArts\CreoleTranslator\Utility\ConfigProvider as UtilityConfigProvider;

final class ConfigProvider extends UtilityConfigProvider
{
    /**
     * @return string
     */
    public function getVocabulariesPath(): string
    {
        return __DIR__ . '/../Fixtures/vocabularies';
    }
}
