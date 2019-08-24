<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Tests\Integration\Laravel;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

abstract class TestCase extends TestbenchTestCase
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
