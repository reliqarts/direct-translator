<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary\Builder;

use DomainException;
use ReliqArts\DirectTranslator\Utility\LanguageCodeChecker;
use ReliqArts\DirectTranslator\Vocabulary;
use ReliqArts\DirectTranslator\Vocabulary\Builder;
use ReliqArts\DirectTranslator\Vocabulary\Exception\InvalidContent;
use ReliqArts\DirectTranslator\Vocabulary\Standard;

final class StandardVocabularyBuilder implements Builder
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
     * {@inheritdoc}
     *
     * @throws InvalidContent
     *
     * @return Vocabulary
     */
    public function create(array $content): Vocabulary
    {
        try {
            $this->validateContent($content);

            return new Standard(
                $content[self::CONTENT_KEY_NAME],
                $content[self::CONTENT_KEY_PHRASES],
                $content[self::CONTENT_KEY_WORDS],
                $content[self::CONTENT_KEY_BASE_LANGUAGE]
            );
        } catch (DomainException $exception) {
            throw new InvalidContent(
                sprintf(
                    'Content of vocabulary is invalid! %s',
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param array $parsedContent
     *
     * @throws DomainException
     *
     * @return bool
     */
    private function validateContent(array $parsedContent): bool
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
