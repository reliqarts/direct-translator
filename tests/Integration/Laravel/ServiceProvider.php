<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Integration\Laravel;

use ReliqArts\DirectTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\DirectTranslator\ServiceProvider\Laravel;
use ReliqArts\DirectTranslator\Tests\Integration\ConfigProvider;

final class ServiceProvider extends Laravel
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(ConfigProviderContract::class, ConfigProvider::class);
    }
}
