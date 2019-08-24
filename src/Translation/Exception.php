<?php

declare(strict_types=1);

namespace ReliqArts\DirectTranslator\Translation;

use DomainException;
use ReliqArts\DirectTranslator\Exception as ExceptionContract;

abstract class Exception extends DomainException implements ExceptionContract
{
}
