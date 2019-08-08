<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration\Laravel;

use ReliqArts\CreoleTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\CreoleTranslator\ServiceProvider\Laravel;
use ReliqArts\CreoleTranslator\Tests\Integration\Open;

final class ServiceProvider extends Laravel
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(ConfigProviderContract::class, Open::class);
    }
}
