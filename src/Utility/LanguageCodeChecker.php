<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Utility;

use ReliqArts\DirectTranslator\Constant\LanguageCodes;

/**
 * Class LanguageCodeChecker.
 *
 * @codeCoverageIgnore
 */
class LanguageCodeChecker
{
    /**
     * @param string $code
     *
     * @return bool
     */
    public function languageCodeExists(string $code): bool
    {
        return !empty($this->getLanguageNameByCode($code));
    }

    /**
     * @param string $code
     *
     * @return string
     */
    private function getLanguageNameByCode(string $code): string
    {
        return LanguageCodes::ISO6391[$code] ?? '';
    }
}
