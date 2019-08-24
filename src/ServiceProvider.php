<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator;

use Psr\Container\ContainerExceptionInterface;

interface ServiceProvider
{
    public const ASSETS_DIR = __DIR__ . '/..';

    /**
     * @param string $name
     * @param mixed  ...$concrete
     */
    public function set(string $name, ...$concrete);

    /**
     * @param string $name
     *
     * @throws ContainerExceptionInterface
     *
     * @return mixed
     */
    public function resolve(string $name);
}
