<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Unit\Vocabulary;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\DirectTranslator\ConfigProvider;
use ReliqArts\DirectTranslator\Vocabulary;
use ReliqArts\DirectTranslator\Vocabulary\Builder;
use ReliqArts\DirectTranslator\Vocabulary\Exception\LoadingFailed;
use ReliqArts\DirectTranslator\Vocabulary\Loader;
use ReliqArts\DirectTranslator\Vocabulary\Reader;
use ReliqArts\DirectTranslator\VocabularyLoader;
use Throwable;

/**
 * Class LoaderTest.
 *
 * @coversDefaultClass \ReliqArts\DirectTranslator\Vocabulary\Loader
 *
 * @internal
 */
final class LoaderTest extends TestCase
{
    private const VOCABULARY_KEY = 'test';
    private const VACABULARY_DIR = __DIR__ . '/../../Fixtures/vocabularies';

    /**
     * @var ConfigProvider|ObjectProphecy
     */
    private $configProvider;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var VocabularyLoader
     */
    private $subject;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->configProvider = $this->prophesize(ConfigProvider::class);
        $this->builder = $this->prophesize(Builder::class);
        $this->reader = $this->prophesize(Reader::class);

        $this->subject = new Loader(
            $this->configProvider->reveal(),
            $this->reader->reveal(),
            $this->builder->reveal()
        );
    }

    /**
     * @throws Throwable
     */
    public function testLoad(): void
    {
        $fileContents = [];
        $filepath = realpath(
            sprintf('%s/%s.%s', self::VACABULARY_DIR, self::VOCABULARY_KEY, 'json')
        );
        $vocabulary = $this->prophesize(Vocabulary::class)->reveal();

        $this->configProvider
            ->getVocabularyDirectories()
            ->shouldBeCalledTimes(1)
            ->willReturn([
                self::VACABULARY_DIR,
            ]);

        $this->reader
            ->read($filepath)
            ->willReturn($fileContents);

        $this->builder
            ->create($fileContents)
            ->shouldBeCalledTimes(1)
            ->willReturn($vocabulary);

        $result = $this->subject->load(self::VOCABULARY_KEY);

        $this->assertSame($vocabulary, $result);
    }

    /**
     * @throws Throwable
     */
    public function testLoadWhenFileNotFound(): void
    {
        $this->configProvider
            ->getVocabularyDirectories()
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'foo',
                'bar',
            ]);

        $this->reader
            ->read(Argument::cetera())
            ->shouldNotBeCalled();

        $this->builder
            ->create(Argument::cetera())
            ->shouldNotBeCalled();

        $this->expectException(LoadingFailed::class);
        $this->expectExceptionMessage('Could not load vocabulary by key: `test`');

        $this->subject->load(self::VOCABULARY_KEY);
    }
}
