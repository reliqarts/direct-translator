<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator;

use JsonSerializable;

interface Vocabulary extends JsonSerializable
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
