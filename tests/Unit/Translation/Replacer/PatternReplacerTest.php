<?php

/** @noinspection PhpTooManyParametersInspection */

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Unit\Translation\Replacer;

use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use ReliqArts\DirectTranslator\Translation\Replacer;
use ReliqArts\DirectTranslator\Translation\Replacer\PatternReplacer;
use ReliqArts\DirectTranslator\Vocabulary;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Class PhraseReplacerTest.
 *
 * @coversDefaultClass \ReliqArts\DirectTranslator\Translation\Replacer\PatternReplacer
 *
 * @internal
 */
final class PatternReplacerTest extends TestCase
{
    /**
     * @var Vocabulary
     */
    private $vocabulary;

    /**
     * @var Replacer
     */
    private $subject;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->vocabulary = $this->prophesize(Vocabulary::class);
        $this->subject = new PatternReplacer();
    }

    /**
     * @dataProvider replaceDataProvider
     * @covers ::buildPatternsAndReplacementsFromMap
     * @covers ::replace
     *
     * @param string $inputText
     * @param array  $phrases
     * @param array  $words
     * @param string $direction
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testReplace(
        string $inputText,
        array $phrases,
        array $words,
        string $direction,
        string $expected
    ): void {
        $this->vocabulary
            ->getPhrases()
            ->shouldBeCalledTimes(1)
            ->willReturn($phrases);

        $this->vocabulary
            ->getWords()
            ->shouldBeCalledTimes(1)
            ->willReturn($words);

        $result = $this->subject->replace(
            $inputText,
            $this->vocabulary->reveal(),
            $direction
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function replaceDataProvider(): array
    {
        $phrases = [
            'how are you' => 'ow yuh duh',
        ];
        $words = [
            'you' => 'yuh',
            'hello' => 'ello',
        ];

        return [
            [
                'Hello! how are you?',
                $phrases,
                $words,
                Replacer::DIRECTION_LTR,
                'ello! ow yuh duh?',
            ],
            [
                'hello! how are you?',
                $phrases,
                $words,
                Replacer::DIRECTION_RTL,
                'hello! how are you?',
            ],
        ];
    }
}
