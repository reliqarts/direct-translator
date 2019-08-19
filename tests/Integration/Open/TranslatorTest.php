<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration\Open;

use Exception;
use ReliqArts\CreoleTranslator\Translator;

/**
 * Class ExecutorTest.
 *
 * @internal
 * @coversNothing
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

        $this->subject = $this->serviceProvider->resolve(Translator::class);
    }

    /**
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
