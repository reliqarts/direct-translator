<?php

/** @noinspection PhpParamsInspection */

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Unit\Vocabulary;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\CreoleTranslator\Utility\LanguageCodeChecker;
use ReliqArts\CreoleTranslator\Vocabulary\Builder;
use ReliqArts\CreoleTranslator\Vocabulary\Exception\InvalidRawContent;

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
     * @var Builder|ObjectProphecy
     */
    private $languageCodeProvider;

    /**
     * @var Builder
     */
    private $subject;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->languageCodeProvider = $this->prophesize(LanguageCodeChecker::class);
        $this->subject = new Builder($this->languageCodeProvider->reveal());
    }

    /**
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContent(): void
    {
        $rawContent = '{
          "name": "Jamaican Patois",
          "baseLanguage": "en",
          "words": {
            "hi": "yo"
          },
          "phrases": {
            "how are you": "\'ow u du"
          }
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(true);

        $result = $this->subject->createStandardFromRawContent($rawContent);

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
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenNameIsInvalid(): void
    {
        $rawContent = '{
          "baseLanguage": "en",
          "words": {
            "hi": "yo"
          },
          "phrases": {
            "how are you": "\'ow u du"
          }
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldNotBeCalled();

        $this->expectException(InvalidRawContent::class);
        $this->expectExceptionMessage('Invalid vocabulary name!');

        $this->subject->createStandardFromRawContent($rawContent);
    }

    /**
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenBaseLanguageIsInvalid(): void
    {
        $rawContent = '{
          "name": "Jamaican Patois",
          "baseLanguage": "en",
          "words": {
            "hi": "yo"
          },
          "phrases": {
            "how are you": "\'ow u du"
          }
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(false);

        $this->expectException(InvalidRawContent::class);
        $this->expectExceptionMessage('Invalid base language: `en`');

        $this->subject->createStandardFromRawContent($rawContent);
    }

    /**
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenWordsIsInvalid(): void
    {
        $rawContent = '{
          "name": "Jamaican Patois",
          "baseLanguage": "en",
          "words": "ds",
          "phrases": {
            "how are you": "\'ow u du"
          }
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(true);

        $this->expectException(InvalidRawContent::class);
        $this->expectExceptionMessage('Invalid type specified for words.');

        $this->subject->createStandardFromRawContent($rawContent);
    }

    /**
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenWordListIsEmpty(): void
    {
        $rawContent = '{
          "name": "Jamaican Patois",
          "baseLanguage": "en",
          "words": {},
          "phrases": {
            "how are you": "\'ow u du"
          }
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(true);

        $this->expectException(InvalidRawContent::class);
        $this->expectExceptionMessage('No words defined for vocabulary!');

        $this->subject->createStandardFromRawContent($rawContent);
    }

    /**
     * @covers ::createStandardFromRawContent
     * @covers ::parseRawContent
     * @covers ::validateParsedContent
     *
     * @throws Exception
     */
    public function testCreateFromRawContentWhenPhrasesIsInvalid(): void
    {
        $rawContent = '{
          "name": "Jamaican Patois",
          "baseLanguage": "en",
          "words": {
            "hi": "yo"
          },
          "phrases": "ds"
        }';

        $this->languageCodeProvider
            ->languageCodeExists('en')
            ->shouldBeCalledTimes(1)
            ->willReturn(true);

        $this->expectException(InvalidRawContent::class);
        $this->expectExceptionMessage('Invalid type specified for phrases.');

        $this->subject->createStandardFromRawContent($rawContent);
    }
}
