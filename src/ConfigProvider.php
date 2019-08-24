<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator;

interface ConfigProvider
{
    public const CONFIG_FILE_PATH = ServiceProvider::ASSETS_DIR . '/config/config.php';

    public const CONFIG_KEY_PACKAGE = 'creoletranslator';
    public const CONFIG_KEY_VOCABULARY_DIRECTORIES = 'vocabulary_directories';

    /**
     * @param string $key
     * @param null   $default
     */
    public function get(string $key, $default = null);

    /**
     * @return array
     */
    public function getVocabularyDirectories(): array;
}
