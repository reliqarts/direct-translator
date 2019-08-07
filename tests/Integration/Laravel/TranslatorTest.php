<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration\Laravel;

use Exception;
use ReliqArts\CreoleTranslator\Translator;

/**
 * Class ExecutorTest.
 *
 * @coversDefaultClass \ReliqArts\CreoleTranslator\Translation\Executor
 *
 * @internal
 */
final class TranslatorTest extends TestCase
{
    private const VOCABULARY_KEY = 'test';

    /**
     * @var Translator
     */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = resolve(Translator::class);
    }

    /**
     * @covers ::translate
     *
     * @throws Exception
     */
    public function testTranslate(): void
    {
        $text = 'Hello. How are you?';
        $expectedTranslation = 'Ello. Ow yuh duh?';
        $output = $this->subject->translate($text, self::VOCABULARY_KEY);

        $this->assertSame($expectedTranslation, $output);
    }
}
