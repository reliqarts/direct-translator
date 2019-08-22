<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\ServiceProvider;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use ReliqArts\CreoleTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\CreoleTranslator\ConfigProvider\Open as OpenConfigProvider;
use ReliqArts\CreoleTranslator\ServiceProvider;
use ReliqArts\CreoleTranslator\Translation\Executor;
use ReliqArts\CreoleTranslator\Translation\Formatter\SentenceCase;
use ReliqArts\CreoleTranslator\Translation\Replacer\PatternReplacer;
use ReliqArts\CreoleTranslator\Translator;
use ReliqArts\CreoleTranslator\Vocabulary\Builder;
use ReliqArts\CreoleTranslator\Vocabulary\Builder\StandardVocabularyBuilder;
use ReliqArts\CreoleTranslator\Vocabulary\Loader;
use ReliqArts\CreoleTranslator\Vocabulary\Reader;
use ReliqArts\CreoleTranslator\Vocabulary\Reader\JsonReader;
use ReliqArts\CreoleTranslator\VocabularyLoader;
use function DI\autowire;
use function DI\get;

class Open implements ServiceProvider
{
    /**
     * @var Container
     */
    private $container;

    /**
     * PHPDIServiceProvider constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $name, ...$concrete)
    {
        $this->container->set($name, $concrete[0]);
    }

    /**
     * @param string $name
     *
     * @throws ContainerExceptionInterface
     *
     * @return mixed
     */
    public function resolve(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * @throws Exception
     */
    protected function init(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($this->getDefinitions());

        $this->container = $containerBuilder->build();
    }

    /**
     * @return array
     */
    protected function getDefinitions(): array
    {
        return [
            ConfigProviderContract::class => get(OpenConfigProvider::class),
            Executor::class => autowire()
                ->method('addReplacer', get(PatternReplacer::class))
                ->method('addFormatter', get(SentenceCase::class)),
            OpenConfigProvider::class => autowire()
                ->method('load'),
            Translator::class => get(Executor::class),
            Builder::class => get(StandardVocabularyBuilder::class),
            Reader::class => get(JsonReader::class),
            VocabularyLoader::class => get(Loader::class),
        ];
    }
}
