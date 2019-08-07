<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator;

use Psr\Container\ContainerExceptionInterface;

interface ServiceProvider
{
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
