<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Translation;

use ReliqArts\DirectTranslator\Exception as ExceptionContract;
use ReliqArts\DirectTranslator\Translation\Exception\TranslationFailed;
use ReliqArts\DirectTranslator\Translator;
use ReliqArts\DirectTranslator\Vocabulary;
use ReliqArts\DirectTranslator\VocabularyLoader;

final class Executor implements Translator
{
    /**
     * @var VocabularyLoader
     */
    private $vocabularyLoader;

    /**
     * @var Formatters
     */
    private $formatters;

    /**
     * @var Replacers
     */
    private $replacers;

    /**
     * Translator constructor.
     *
     * @param VocabularyLoader $vocabularyLoader
     */
    public function __construct(VocabularyLoader $vocabularyLoader)
    {
        $this->vocabularyLoader = $vocabularyLoader;
        $this->formatters = new Formatters();
        $this->replacers = new Replacers();
    }

    /**
     * {@inheritdoc}
     *
     * @throws TranslationFailed
     *
     * @return string
     */
    public function translate(string $text, string $vocabularyKey): string
    {
        try {
            $vocabulary = $this->vocabularyLoader->load($vocabularyKey);

            return $this->format($this->replace($text, $vocabulary));
        } catch (ExceptionContract $exception) {
            throw new TranslationFailed(
                sprintf('Translation failed. %s', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param Formatter $formatter
     */
    public function addFormatter(Formatter $formatter): void
    {
        $this->formatters->add($formatter);
    }

    /**
     * @param Replacer $replacer
     */
    public function addReplacer(Replacer $replacer): void
    {
        $this->replacers->add($replacer);
    }

    /**
     * @param string $inputText
     *
     * @return string
     */
    private function format(string $inputText): string
    {
        $result = $inputText;

        foreach ($this->formatters as $formatter) {
            $result = $formatter->apply($result);
        }

        return $result;
    }

    /**
     * @param string     $inputText
     * @param Vocabulary $vocabulary
     *
     * @return string
     */
    private function replace(string $inputText, Vocabulary $vocabulary): string
    {
        $result = $inputText;

        foreach ($this->replacers as $replacer) {
            $result = $replacer->replace($result, $vocabulary);
        }

        return $result;
    }
}
