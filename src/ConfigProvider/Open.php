<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\ConfigProvider;

use ReliqArts\DirectTranslator\ConfigProvider as ConfigProviderContract;

class Open implements ConfigProviderContract
{
    /**
     * @var array
     */
    private $config;

    /**
     * @codeCoverageIgnore
     *
     * @param string $configFilePath
     */
    public function load(string $configFilePath = self::CONFIG_FILE_PATH)
    {
        $this->config = require $configFilePath;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $data = $this->config;

        foreach ($segments as $segment) {
            if (empty($data[$segment])) {
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getVocabularyDirectories(): array
    {
        return $this->get('vocabulary_directories', []);
    }
}
