<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Contract;

interface LanguageCodeProvider
{
    /**
     * @return string[]
     */
    public function getCodes(): array;

    /**
     * @param string $code
     *
     * @return string
     */
    public function getLanguageNameByCode(string $code): string;

    /**
     * @param string $name
     *
     * @return string
     */
    public function getLanguageCodeByName(string $name): string;

    /**
     * @param string $code
     *
     * @return bool
     */
    public function languageCodeExists(string $code): bool;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function languageNameExists(string $name): bool;
}
