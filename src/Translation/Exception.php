<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Translation;

use DomainException;
use ReliqArts\CreoleTranslator\Exception as ExceptionContract;

abstract class Exception extends DomainException implements ExceptionContract
{
}
