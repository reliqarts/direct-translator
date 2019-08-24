<?php

/** @noinspection PhpParamsInspection */

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Unit\Vocabulary;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\DirectTranslator\Utility\LanguageCodeChecker;
use ReliqArts\DirectTranslator\Vocabulary\Builder;
use ReliqArts\DirectTranslator\Vocabulary\Builder\StandardVocabularyBuilder;
use ReliqArts\DirectTranslator\Vocabulary\Exception\InvalidContent;

/**
 * Class VocabularyBuilderTest.
 *
 * @coversDefaultClass \ReliqArts\DirectTranslator\Vocabulary\Builder\StandardVocabularyBuilder
 *
 * @internal
 */
final class StandardVocabularyBuilderTest extends TestCase
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

        $this->subject = new StandardVocabularyBuilder($this->languageCodeChecker->reveal());
    }

    /**
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreate(): void
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

        $result = $this->subject->create($content);

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
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreateWhenNameIsInvalid(): void
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

        $this->subject->create($content);
    }

    /**
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreateWhenBaseLanguageIsInvalid(): void
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

        $this->subject->create($content);
    }

    /**
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreateWhenWordsIsInvalid(): void
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

        $this->subject->create($content);
    }

    /**
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreateWhenWordListIsEmpty(): void
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

        $this->subject->create($content);
    }

    /**
     * @covers ::<public>
     * @covers ::validateContent
     *
     * @throws Exception
     */
    public function testCreateWhenPhrasesIsInvalid(): void
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

        $this->subject->create($content);
    }
}
