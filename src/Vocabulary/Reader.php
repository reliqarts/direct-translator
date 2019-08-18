<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use Exception;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\ReadingFailed;

class Reader
{
    private const KEY_URL = 'url';

    /**
     * @param string $path
     *
     * @throws ReadingFailed
     *
     * @return array
     */
    public function read(string $path): array
    {
        try {
            $filePath = $path;

            do {
                $json = file_get_contents($filePath);
                $content = json_decode($json, true);
                $filePath = $content[self::KEY_URL] ?? null;
            } while (!empty($filePath));

            if (empty($content)) {
                throw new DomainException(sprintf('No content found.'));
            }

            return $content;
        } catch (Exception $exception) {
            throw new ReadingFailed(
                sprintf('Failed to read vocabulary: `%s`', $path),
                $exception->getCode(),
                $exception
            );
        }
    }
}
