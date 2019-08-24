<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\ConfigProvider;

use ReliqArts\DirectTranslator\ConfigProvider;

class Laravel implements ConfigProvider
{
    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        return config($key, $default);
    }

    /**
     * @return array
     */
    public function getVocabularyDirectories(): array
    {
        return config($this->finalizeConfigKey(static::CONFIG_KEY_VOCABULARY_DIRECTORIES), []);
    }

    /**
     * Ensure config key is package specific.
     *
     * @param $key
     *
     * @return string
     */
    private function finalizeConfigKey($key): string
    {
        if (strpos($key, static::CONFIG_KEY_PACKAGE) === 0) {
            return $key;
        }

        return sprintf('%s.%s', static::CONFIG_KEY_PACKAGE, $key);
    }
}
