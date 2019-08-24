<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\ServiceProvider;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use ReliqArts\DirectTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\DirectTranslator\ConfigProvider\Laravel as LaravelConfigProvider;
use ReliqArts\DirectTranslator\ServiceProvider;
use ReliqArts\DirectTranslator\Translation\Executor;
use ReliqArts\DirectTranslator\Translation\Formatter\SentenceCase;
use ReliqArts\DirectTranslator\Translation\Replacer\PatternReplacer;
use ReliqArts\DirectTranslator\Translator;
use ReliqArts\DirectTranslator\Vocabulary\Builder;
use ReliqArts\DirectTranslator\Vocabulary\Builder\StandardVocabularyBuilder;
use ReliqArts\DirectTranslator\Vocabulary\Loader;
use ReliqArts\DirectTranslator\Vocabulary\Reader;
use ReliqArts\DirectTranslator\Vocabulary\Reader\JsonReader;
use ReliqArts\DirectTranslator\VocabularyLoader;

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
