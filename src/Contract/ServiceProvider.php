<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Contract;

interface ServiceProvider
{
    /**
     * Registers application services.
     */
    public function register(): void;
}
