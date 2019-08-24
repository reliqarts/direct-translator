<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Integration;

use ReliqArts\DirectTranslator\ConfigProvider\Open as OpenConfigProvider;

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
