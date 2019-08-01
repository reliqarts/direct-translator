<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Contract;

interface Vocabulary
{
    public function getName(): string;

    /**
     * @return string
     */
    public function getLanguageCode(): string;

    /**
     * @return string[]
     */
    public function getPhrases(): array;

    /**
     * @return string[]
     */
    public function getWords(): array;
}
