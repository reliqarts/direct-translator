<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Integration\Open;

use PHPUnit\Framework\TestCase as BaseTestCase;
use ReliqArts\DirectTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\DirectTranslator\ServiceProvider as ServiceProviderContract;
use ReliqArts\DirectTranslator\ServiceProvider\Open as ServiceProvider;
use ReliqArts\DirectTranslator\Tests\Integration\ConfigProvider;
use function DI\get;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var ServiceProviderContract
     */
    protected $serviceProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceProvider = new ServiceProvider();
        $this->serviceProvider->set(ConfigProviderContract::class, get(ConfigProvider::class));
    }
}
