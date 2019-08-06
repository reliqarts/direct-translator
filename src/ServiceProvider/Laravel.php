<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\ServiceProvider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use ReliqArts\CreoleTranslator\ServiceProvider;
use ReliqArts\CreoleTranslator\Translator;
use ReliqArts\CreoleTranslator\VocabularyLoader;
use ReliqArts\CreoleTranslator\Translation\Executor;
use ReliqArts\CreoleTranslator\Translation\Replacer\PatternReplacer;
use ReliqArts\CreoleTranslator\Vocabulary\Loader;

final class Laravel extends IlluminateServiceProvider implements ServiceProvider, DeferrableProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->singleton(VocabularyLoader::class, Loader::class);
        $this->app->singleton(Translator::class, function (): Translator {
            $vocabularyLoader = $this->app->get(VocabularyLoader::class);
            $executor = new Executor($vocabularyLoader);

            $executor->addReplacer(new PatternReplacer());

            return $executor;
        });
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    public function resolve(string $key)
    {
        return $this->app->get($key);
    }
}
