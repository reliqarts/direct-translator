<?php

/** @noinspection PhpParamsInspection */

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Unit\Vocabulary;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\CreoleTranslator\Utility\LanguageCodeChecker;
use ReliqArts\CreoleTranslator\Vocabulary\Builder;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\InvalidContent;

/**
 * Class VocabularyBuilderTest.
 *
 * @coversDefaultClass \ReliqArts\CreoleTranslator\Vocabulary\Builder
 *
 * @internal
 */
final class BuilderTest extends TestCase
{
    /**
     * @var LanguageCodeChecker|ObjectProphecy
     */
    private $languageCodeChecker;

    /**
     * @var Builder
     */
    private $subject;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->languageCodeChecker = $this->prophesize(LanguageCodeChecker::class);

        $this->languageCodeChecker
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(true);

        $this->subject = new Builder($this->languageCodeChecker->reveal());
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContent(): void
    {
        $content = [
            'name' => 'Jamaican Patois',
            'baseLanguage' => 'en',
            'words' => [
                'hi' => 'yo',
            ],
            'phrases' => [
                'how are you' => '\'ow u du',
            ],
        ];

        $result = $this->subject->createStandard($content);

        $this->assertSame('Jamaican Patois', $result->getName());
        $this->assertSame('en', $result->getLanguageCode());
        $this->assertSame(
            [
                'how are you' => '\'ow u du',
            ],
            $result->getPhrases()
        );
        $this->assertSame(
            [
                'hi' => 'yo',
            ],
            $result->getWords()
        );
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenNameIsInvalid(): void
    {
        $content = [
            'name' => '',
            'baseLanguage' => 'en',
            'words' => [
                'hi' => 'yo',
            ],
            'phrases' => [
                'how are you' => '\'ow u du',
            ],
        ];

        $this->languageCodeChecker
            ->languageCodeExists('en')
            ->shouldNotBeCalled();

        $this->expectException(InvalidContent::class);
        $this->expectExceptionMessage('Invalid vocabulary name!');

        $this->subject->createStandard($content);
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenBaseLanguageIsInvalid(): void
    {
        $content = [
            'name' => 'Jamaican Patois',
            'baseLanguage' => 'en',
            'words' => [
                'hi' => 'yo',
            ],
            'phrases' => [
                'how are you' => '\'ow u du',
            ],
        ];

        $this->languageCodeChecker
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(false);

        $this->expectException(InvalidContent::class);
        $this->expectExceptionMessage('Invalid base language: `en`');

        $this->subject->createStandard($content);
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenWordsIsInvalid(): void
    {
        $content = [
            'name' => 'Jamaican Patois',
            'baseLanguage' => 'en',
            'words' => 'foo,bar',
            'phrases' => [
                'how are you' => '\'ow u du',
            ],
        ];

        $this->expectException(InvalidContent::class);
        $this->expectExceptionMessage('Invalid type specified for words.');

        $this->subject->createStandard($content);
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenWordListIsEmpty(): void
    {
        $content = [
            'name' => 'Jamaican Patois',
            'baseLanguage' => 'en',
            'words' => [],
            'phrases' => [
                'how are you' => '\'ow u du',
            ],
        ];

        $this->expectException(InvalidContent::class);
        $this->expectExceptionMessage('No words defined for vocabulary!');

        $this->subject->createStandard($content);
    }

    /**
     * @covers ::createStandard
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenPhrasesIsInvalid(): void
    {
        $content = [
            'name' => 'Jamaican Patois',
            'baseLanguage' => 'en',
            'words' => [
                'hi' => 'yo',
            ],
            'phrases' => 'how are you, \'ow u du',
        ];

        $this->expectException(InvalidContent::class);
        $this->expectExceptionMessage('Invalid type specified for phrases.');

        $this->subject->createStandard($content);
    }
}
