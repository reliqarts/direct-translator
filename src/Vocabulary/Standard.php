<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use ReliqArts\CreoleTranslator\Vocabulary;

final class Standard implements Vocabulary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $languageCode;

    /**
     * @var string[]
     */
    private $phrases;

    /**
     * @var string[]
     */
    private $words;

    /**
     * Vocabulary constructor.
     *
     * @param string $name
     * @param array  $phrases
     * @param array  $words
     * @param string $languageCode
     */
    public function __construct(string $name, array $phrases, array $words, string $languageCode)
    {
        $this->name = $name;
        $this->languageCode = $languageCode;
        $this->phrases = $phrases;
        $this->words = $words;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @return string[]
     */
    public function getPhrases(): array
    {
        return $this->phrases;
    }

    /**
     * @return string[]
     */
    public function getWords(): array
    {
        return $this->words;
    }
}
