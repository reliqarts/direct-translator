<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use ReliqArts\CreoleTranslator\Contract\ConfigProvider;
use ReliqArts\CreoleTranslator\Contract\Vocabulary as VocabularyContract;
use ReliqArts\CreoleTranslator\Contract\VocabularyBuilder;
use ReliqArts\CreoleTranslator\Contract\VocabularyLoader;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\LoadingFailed;

final class Loader implements VocabularyLoader
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var VocabularyBuilder
     */
    private $vocabularyBuilder;

    /**
     * VocabularyLoader constructor.
     *
     * @param ConfigProvider    $configProvider
     * @param VocabularyBuilder $vocabularyBuilder
     */
    public function __construct(ConfigProvider $configProvider, VocabularyBuilder $vocabularyBuilder)
    {
        $this->configProvider = $configProvider;
        $this->vocabularyBuilder = $vocabularyBuilder;
    }

    /**
     * {@inheritdoc}
     *
     * @throws LoadingFailed
     *
     * @return VocabularyContract
     */
    public function loadByKey(string $key): VocabularyContract
    {
        $vocabulariesPath = $this->configProvider->getVocabulariesPath();
        $vocabFilePath = sprintf('%s/%s', $vocabulariesPath, $key);
        $vocabContent = file_get_contents($vocabFilePath);

        if (!$vocabContent) {
            throw new LoadingFailed(sprintf('Could not read expected vocabulary file: `%s`', $vocabFilePath));
        }

        return $this->vocabularyBuilder->createFromRawContent($vocabContent);
    }
}
