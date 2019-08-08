<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration;

use ReliqArts\CreoleTranslator\ConfigProvider\Open as OpenConfigProvider;

final class ConfigProvider extends OpenConfigProvider
{
    /**
     * @return array
     */
    public function getVocabularyDirectories(): array
    {
        return [__DIR__ . '/../Fixtures/vocabularies'];
    }
}
