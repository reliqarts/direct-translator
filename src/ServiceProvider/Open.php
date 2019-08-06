<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\ServiceProvider;

use DI\Container;
use Psr\Container\ContainerExceptionInterface;
use ReliqArts\CreoleTranslator\Contract\ServiceProvider;

final class Open implements ServiceProvider
{
    /**
     * @var Container
     */
    private $container;

    /**
     * PHPDIServiceProvider constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        // TODO: Implement register() method.
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    public function resolve(string $key)
    {
        return $this->container->get($key);
    }
}
