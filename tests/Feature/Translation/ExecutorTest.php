<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Tests\Feature\Translation;

use PHPUnit\Framework\TestCase;
use ReliqArts\CreoleTranslator\Translation\Executor;

final class ExecutorTest extends TestCase
{
    /**
     * @var Executor
     */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Executor();
    }
}
