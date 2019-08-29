<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Feature\Utility;

use PHPUnit\Framework\TestCase;
use ReliqArts\DirectTranslator\Utility\RemoteFileAssistant;

/**
 * Class RemoteFileAssistantTest.
 *
 * @coversDefaultClass \ReliqArts\DirectTranslator\Utility\RemoteFileAssistant
 *
 * @internal
 */
final class RemoteFileAssistantTest extends TestCase
{
    /**
     * @var RemoteFileAssistant
     */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new RemoteFileAssistant();
    }

    /**
     * @
     */
    public function testFileExists(): void
    {
        $existingUrl = 'https://reliqarts.com';
        $nonExistentUrl = 'https://reliqarts.co.m';

        $this->assertTrue($this->subject->fileExists($existingUrl));
        $this->assertFalse($this->subject->fileExists($nonExistentUrl));
    }
}
