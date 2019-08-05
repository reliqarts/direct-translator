<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Unit\Translation;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\CreoleTranslator\Contract\Translator as TranslatorContract;
use ReliqArts\CreoleTranslator\Contract\VocabularyLoader;
use ReliqArts\CreoleTranslator\Translation\Executor;

/**
 * @internal
 * @coversNothing
 */
final class ExecutorTest extends TestCase
{
    /**
     * @var TranslatorContract
     */
    private $subject;
    /**
     * @var ObjectProphecy|VocabularyLoader
     */
    private $vocabularyLoader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vocabularyLoader = $this->prophesize(VocabularyLoader::class);
        $this->subject = new Executor($this->vocabularyLoader->reveal());
    }

    /**
     * @dataProvider translateDataProvider
     *
     * @param string $text
     * @param string $expectedResult
     *
     * @throws \Exception
     */
    public function testTranslate(string $text, string $expectedResult): void
    {
        $this->markTestSkipped('Early days yet...');

        $result = $this->subject->translate($text);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function translateDataProvider(): array
    {
        return [
            [
                'Hello! What\'s up?',
                'Yow! Whaa gwaan?',
            ],
            [
                'I\'m going down the road.',
                'Mi a go dung di road.',
            ],
        ];
    }
}
