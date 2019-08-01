<?php

/** @noinspection PhpUndefinedMethodInspection @noinspection PhpParamsInspection */

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Unit\Vocabulary;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\CreoleTranslator\Contract\LanguageCodeProvider;
use ReliqArts\CreoleTranslator\Contract\VocabularyBuilder as VocabularyBuilderContract;
use ReliqArts\CreoleTranslator\Vocabulary\Builder;

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
     * @var LanguageCodeProvider|ObjectProphecy
     */
    private $languageCodeProvider;

    /**
     * @var VocabularyBuilderContract
     */
    private $subject;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->languageCodeProvider = $this->prophesize(LanguageCodeProvider::class);
        $this->subject = new Builder($this->languageCodeProvider->reveal());
    }

    /**
     * @covers ::createFromRawContent
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

        $result = $this->subject->createFromRawContent($rawContent);

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
}
