<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use ReliqArts\CreoleTranslator\Utility\LanguageCodeChecker;
use ReliqArts\CreoleTranslator\Vocabulary;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\InvalidRawContent;

final class Builder
{
    private const CONTENT_KEY_NAME = 'name';
    private const CONTENT_KEY_BASE_LANGUAGE = 'baseLanguage';
    private const CONTENT_KEY_WORDS = 'words';
    private const CONTENT_KEY_PHRASES = 'phrases';

    /**
     * @var LanguageCodeChecker
     */
    private $languageCodeValidator;

    /**
     * VocabularyBuilder constructor.
     *
     * @param LanguageCodeChecker $languageCodeChecker
     */
    public function __construct(LanguageCodeChecker $languageCodeChecker)
    {
        $this->languageCodeValidator = $languageCodeChecker;
    }

    /**
     * @param string $rawContent
     *
     * @throws InvalidRawContent
     *
     * @return Standard
     */
    public function createStandardFromRawContent(string $rawContent): Vocabulary
    {
        $parsedContent = $this->parseRawContent($rawContent);

        try {
            $this->validateParsedContent($parsedContent);

            return new Standard(
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

        if (!$this->languageCodeValidator->languageCodeExists($baseLanguage)) {
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
