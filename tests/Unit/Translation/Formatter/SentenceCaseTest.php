<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Unit\Translation\Formatter;

use Exception;
use PHPUnit\Framework\TestCase;
use ReliqArts\DirectTranslator\Translation\Formatter;
use ReliqArts\DirectTranslator\Translation\Formatter\SentenceCase;

/**
 * Class SentenceCaseTest.
 *
 * @coversDefaultClass \ReliqArts\DirectTranslator\Translation\Formatter\SentenceCase
 *
 * @internal
 */
final class SentenceCaseTest extends TestCase
{
    /**
     * @var Formatter
     */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new SentenceCase();
    }

    /**
     * @covers ::apply
     * @dataProvider sentenceProvider
     *
     * @param string $input
     * @param string $expectedResult
     *
     * @throws Exception
     */
    public function testApply(string $input, string $expectedResult): void
    {
        $result = $this->subject->apply($input);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function sentenceProvider(): array
    {
        return [
            [
                'hello world. how are you?',
                'Hello world. How are you?',
            ],
            [
                'lorem ipsum, yo',
                'Lorem ipsum, yo',
            ],
        ];
    }
}
