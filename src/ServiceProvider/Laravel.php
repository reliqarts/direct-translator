<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\ServiceProvider;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use ReliqArts\CreoleTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\CreoleTranslator\ConfigProvider\Laravel as LaravelConfigProvider;
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

class Laravel extends IlluminateServiceProvider implements ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->handleConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->singleton(ConfigProviderContract::class, LaravelConfigProvider::class);
        $this->app->singleton(VocabularyLoader::class, Loader::class);
        $this->app->singleton(Builder::class, StandardVocabularyBuilder::class);
        $this->app->singleton(Reader::class, JsonReader::class);
        $this->app->singleton(Translator::class, function (Application $app): Translator {
            $executor = new Executor($app->get(VocabularyLoader::class));

            $executor->addFormatter($app->get(SentenceCase::class));
            $executor->addReplacer($app->get(PatternReplacer::class));

            return $executor;
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [
            Translator::class,
            VocabularyLoader::class,
        ];
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
        return $this->app->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $name, ...$concrete)
    {
        $this->app->bind($name, ...$concrete);
    }

    /**
     * @return self
     */
    private function handleConfig(): self
    {
        $configFilePath = ConfigProviderContract::CONFIG_FILE_PATH;
        $configKey = ConfigProviderContract::CONFIG_KEY_PACKAGE;

        // merge config
        $this->mergeConfigFrom($configFilePath, $configKey);

        // allow publishing the config file, with tag: [package config key]:config
        $this->publishes(
            [
                $configFilePath => config_path(sprintf('%s.php', $configKey)),
            ],
            sprintf('%s:config', $configKey)
        );

        return $this;
    }
}
