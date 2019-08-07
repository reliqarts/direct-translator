<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Integration\Open;

use PHPUnit\Framework\TestCase as BaseTestCase;
use ReliqArts\CreoleTranslator\ConfigProvider as ConfigProviderContract;
use ReliqArts\CreoleTranslator\ServiceProvider as ServiceProviderContract;
use ReliqArts\CreoleTranslator\ServiceProvider\Open as ServiceProvider;
use ReliqArts\CreoleTranslator\Tests\Integration\ConfigProvider;
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
