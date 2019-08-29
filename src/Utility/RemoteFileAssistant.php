<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Utility;

class RemoteFileAssistant
{
    /**
     * @param string $url
     *
     * @return bool
     */
    public function fileExists(string $url): bool
    {
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $headers = @get_headers($url) ?: [''];

        return strpos(current($headers), '200') !== false;
    }
}
