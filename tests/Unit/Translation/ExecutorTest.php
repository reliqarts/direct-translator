<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Unit\Translation;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\CreoleTranslator\Translation\Exception\TranslationFailed;
use ReliqArts\CreoleTranslator\Translation\Executor;
use ReliqArts\CreoleTranslator\Translation\Formatter;
use ReliqArts\CreoleTranslator\Translation\Replacer;
use ReliqArts\CreoleTranslator\Vocabulary;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\LoadingFailed;
use ReliqArts\CreoleTranslator\VocabularyLoader;
use Throwable;

/**
 * Class ExecutorTest.
 *
 * @coversDefaultClass \ReliqArts\CreoleTranslator\Translation\Executor
 *
 * @internal
 */
final class ExecutorTest extends TestCase
{
    private const VOCABULARY_KEY = 'jam';

    /**
     * @var Formatter|ObjectProphecy
     */
    private $formatter;

    /**
     * @var ObjectProphecy|Replacer
     */
    private $replacer;

    /**
     * @var ObjectProphecy|VocabularyLoader
     */
    private $vocabularyLoader;

    /**
     * @var Executor
     */
    private $subject;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter = $this->prophesize(Formatter::class);
        $this->replacer = $this->prophesize(Replacer::class);
        $this->vocabularyLoader = $this->prophesize(VocabularyLoader::class);
        $this->subject = new Executor($this->vocabularyLoader->reveal());

        $this->subject
            ->addFormatter($this->formatter->reveal());
        $this->subject
            ->addReplacer($this->replacer->reveal());
    }

    /**
     * @throws Throwable
     */
    public function testTranslate(): void
    {
        $input = 'hello';
        $expectedResult = 'ello';
        $vocabularyKey = self::VOCABULARY_KEY;
        $vocabulary = $this->prophesize(Vocabulary::class);

        $this->formatter
            ->apply($expectedResult)
            ->shouldBeCalledTimes(1)
            ->willReturn($expectedResult);

        $this->replacer
            ->replace($input, $vocabulary)
            ->shouldBeCalledTimes(1)
            ->willReturn($expectedResult);

        $this->vocabularyLoader
            ->loadByKey($vocabularyKey)
            ->shouldBeCalledTimes(1)
            ->willReturn($vocabulary);

        $result = $this->subject->translate($input, $vocabularyKey);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @covers ::<public>
     *
     * @throws Throwable
     */
    public function testTranslateWhenVocabularyLoadingFails(): void
    {
        $input = 'hello';
        $vocabularyKey = self::VOCABULARY_KEY;

        $this->formatter
            ->apply(Argument::cetera())
            ->shouldNotBeCalled();

        $this->replacer
            ->replace(Argument::cetera())
            ->shouldNotBeCalled();

        $this->vocabularyLoader
            ->loadByKey($vocabularyKey)
            ->shouldBeCalledTimes(1)
            ->willThrow(LoadingFailed::class);

        $this->expectException(TranslationFailed::class);
        $this->expectExceptionMessage('Translation failed');

        $this->subject->translate($input, $vocabularyKey);
    }
}
