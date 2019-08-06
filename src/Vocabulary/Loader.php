<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use ReliqArts\CreoleTranslator\Utility\ConfigProvider;
use ReliqArts\CreoleTranslator\Vocabulary as VocabularyContract;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\LoadingFailed;
use ReliqArts\CreoleTranslator\VocabularyLoader;

final class Loader implements VocabularyLoader
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Builder
     */
    private $vocabularyBuilder;

    /**
     * VocabularyLoader constructor.
     *
     * @param ConfigProvider $configProvider
     * @param Builder        $vocabularyBuilder
     */
    public function __construct(ConfigProvider $configProvider, Builder $vocabularyBuilder)
    {
        $this->configProvider = $configProvider;
        $this->vocabularyBuilder = $vocabularyBuilder;
    }

    /**
     * @param string $key
     *
     * @return VocabularyContract
     * @throws LoadingFailed
     */
    public function loadByKey(string $key): VocabularyContract
    {
        try {
            $vocabulariesPath = $this->configProvider->getVocabulariesPath();
            $vocabFilePath = sprintf('%s/%s', $vocabulariesPath, $key);
            $vocabContent = file_get_contents($vocabFilePath);

            if (!$vocabContent) {
                throw new DomainException(
                    sprintf('Vocabulary file empty or could not be read. (path: `%s`)', $vocabFilePath)
                );
            }

            return $this->vocabularyBuilder->createStandardFromRawContent($vocabContent);
        } catch (DomainException $exception) {
            throw new LoadingFailed(
                sprintf('Could not load vocabulary. %s', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }
}
