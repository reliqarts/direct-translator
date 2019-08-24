<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Vocabulary\Reader;

use DomainException;
use Exception;
use ReliqArts\DirectTranslator\Vocabulary\Exception\ReadingFailed;
use ReliqArts\DirectTranslator\Vocabulary\Reader;

final class JsonReader implements Reader
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
                throw new DomainException(sprintf('No/invalid content found.'));
            }

            return $content;
        } catch (Exception $exception) {
            throw new ReadingFailed(
                sprintf('Failed to read vocabulary at: `%s`', $path),
                $exception->getCode(),
                $exception
            );
        }
    }
}
