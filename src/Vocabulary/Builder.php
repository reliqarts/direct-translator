<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use ReliqArts\CreoleTranslator\Contract\LanguageCodeProvider;
use ReliqArts\CreoleTranslator\Contract\Vocabulary as VocabularyContract;
use ReliqArts\CreoleTranslator\Contract\VocabularyBuilder as VocabularyBuilderContract;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\InvalidRawContent;

final class Builder implements VocabularyBuilderContract
{
    private const CONTENT_KEY_NAME = 'name';
    private const CONTENT_KEY_BASE_LANGUAGE = 'baseLanguage';
    private const CONTENT_KEY_WORDS = 'words';
    private const CONTENT_KEY_PHRASES = 'phrases';

    /**
     * @var LanguageCodeProvider
     */
    private $languageCodeProvider;

    /**
     * VocabularyBuilder constructor.
     *
     * @param LanguageCodeProvider $languageCodeProvider
     */
    public function __construct(LanguageCodeProvider $languageCodeProvider)
    {
        $this->languageCodeProvider = $languageCodeProvider;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidRawContent
     *
     * @return Vocabulary
     */
    public function createFromRawContent(string $rawContent): VocabularyContract
    {
        $parsedContent = $this->parseRawContent($rawContent);

        try {
            $this->validateParsedContent($parsedContent);

            return new Vocabulary(
                $parsedContent[self::CONTENT_KEY_NAME],
                $parsedContent[self::CONTENT_KEY_PHRASES],
                $parsedContent[self::CONTENT_KEY_WORDS],
                $parsedContent[self::CONTENT_KEY_BASE_LANGUAGE]
            );
        } catch (DomainException $exception) {
            throw new InvalidRawContent(
                sprintf(
                    'Raw content of vocabulary is invalid! %s',
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param string $rawContent
     *
     * @return array
     */
    private function parseRawContent(string $rawContent): array
    {
        return json_decode($rawContent, true);
    }

    /**
     * @param array $parsedContent
     *
     * @throws DomainException
     *
     * @return bool
     */
    private function validateParsedContent(array $parsedContent): bool
    {
        $name = $parsedContent[self::CONTENT_KEY_NAME] ?? '';
        $baseLanguage = $parsedContent[self::CONTENT_KEY_BASE_LANGUAGE] ?? '';
        $words = $parsedContent[self::CONTENT_KEY_WORDS] ?? '';
        $phrases = $parsedContent[self::CONTENT_KEY_PHRASES] ?? '';

        if (empty($name) || !is_string($name)) {
            throw new DomainException('Invalid vocabulary name!');
        }

        if (empty($baseLanguage) || !$this->languageCodeProvider->languageCodeExists($baseLanguage)) {
            throw new DomainException(sprintf('Invalid base language: `%s`', $baseLanguage));
        }

        if (!is_array($words)) {
            throw new DomainException('Invalid type specified for words.');
        }

        if (empty($words)) {
            throw new DomainException('No words defined for vocabulary!');
        }

        if (!is_array($phrases)) {
            throw new DomainException('Invalid type specified for phrases.');
        }

        return true;
    }
}
