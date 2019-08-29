<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary;

use DomainException;
use Exception;
use ReliqArts\DirectTranslator\ConfigProvider;
use ReliqArts\DirectTranslator\Utility\RemoteFileAssistant;
use ReliqArts\DirectTranslator\Vocabulary as VocabularyContract;
use ReliqArts\DirectTranslator\Vocabulary\Exception\LoadingFailed;
use ReliqArts\DirectTranslator\VocabularyLoader;

final class Loader implements VocabularyLoader
{
    private const VOCAB_FILE_EXTENSION = 'json';

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var RemoteFileAssistant
     */
    private $remoteFileAssistant;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * VocabularyLoader constructor.
     *
     * @param ConfigProvider      $configProvider
     * @param RemoteFileAssistant $remoteFileAssistant
     * @param Reader              $reader
     * @param Builder             $builder
     */
    public function __construct(
        ConfigProvider $configProvider,
        RemoteFileAssistant $remoteFileAssistant,
        Reader $reader,
        Builder $builder
    ) {
        $this->configProvider = $configProvider;
        $this->remoteFileAssistant = $remoteFileAssistant;
        $this->reader = $reader;
        $this->builder = $builder;
    }

    /**
     * @param string $key
     *
     * @throws LoadingFailed
     *
     * @return VocabularyContract
     */
    public function load(string $key): VocabularyContract
    {
        try {
            $filePath = $this->getVocabularyFilePath($key);

            return $this->builder->create($this->reader->read($filePath));
        } catch (Exception $exception) {
            throw new LoadingFailed(
                sprintf('Could not load vocabulary by key: `%s`', $key),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param string $key
     *
     * @throws DomainException
     *
     * @return null|string
     */
    private function getVocabularyFilePath(string $key): ?string
    {
        $vocabularyDirectories = $this->configProvider->getVocabularyDirectories();

        foreach ($vocabularyDirectories as $directory) {
            $path = sprintf('%s/%s.%s', $directory, $key, self::VOCAB_FILE_EXTENSION);
            $vocabularyPath = realpath($path);

            if (!empty($vocabularyPath)) {
                return $vocabularyPath;
            }

            if ($this->pathIsUrl($path) && $this->remoteFileAssistant->fileExists($path)) {
                return $path;
            }
        }

        throw new DomainException(
            sprintf('Vocabulary file not found for key: `%s`.', $key)
        );
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function pathIsUrl(string $path): bool
    {
        return !empty(filter_var($path, FILTER_VALIDATE_URL));
    }
}
