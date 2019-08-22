<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use ReliqArts\CreoleTranslator\Exception as ExceptionContract;

abstract class Exception extends DomainException implements ExceptionContract
{
}
