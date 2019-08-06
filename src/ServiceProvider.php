<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator;

use Psr\Container\ContainerExceptionInterface;

interface ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void;

    /**
     * @param string $key
     *
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    public function resolve(string $key);
}
