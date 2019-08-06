<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Translation\Replacer;

use ReliqArts\CreoleTranslator\Translation\Replacer;
use ReliqArts\CreoleTranslator\Vocabulary;

final class PatternReplacer implements Replacer
{
    /**
     * @inheritDoc
     *
     * @return string
     */
    public function replace(
        string $inputText,
        Vocabulary $vocabulary,
        string $direction = self::DIRECTION_LTR
    ): string {
        $map = array_replace($vocabulary->getPhrases(), $vocabulary->getWords());

        list($patterns, $replacements) = $this->buildPatternsAndReplacementsFromMap($map, $direction);

        return preg_replace($patterns, $replacements, $inputText);
    }

    /**
     * @param array  $map
     * @param string $direction
     *
     * @return string[]
     */
    protected function buildPatternsAndReplacementsFromMap(array $map, string $direction): array
    {
        $finalMap = $map;
        if ($direction === self::DIRECTION_RTL) {
            $finalMap = array_flip($map);
        }

        $patterns = array_map(
            function (string $wordOrPhrase): string {
                return sprintf('/\b%s\b/ui', $wordOrPhrase);
            },
            array_keys($finalMap)
        );
        $replacements = array_values($finalMap);

        return [$patterns, $replacements];
    }
}
