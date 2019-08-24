<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary;

use DomainException;
use Exception;
use ReliqArts\DirectTranslator\ConfigProvider;
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
     * @param ConfigProvider $configProvider
     * @param Reader         $reader
     * @param Builder        $builder
     */
    public function __construct(
        ConfigProvider $configProvider,
        Reader $reader,
        Builder $builder
    ) {
        $this->configProvider = $configProvider;
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

            if ($vocabularyPath = realpath($path)) {
                return $vocabularyPath;
            }
        }

        throw new DomainException(
            sprintf('Vocabulary file not found for key: `%s`.', $key)
        );
    }
}
