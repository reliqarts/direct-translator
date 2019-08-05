<?php

declare(strict_types=1);

namespace ReliqArts\CreoleTranslator\Vocabulary;

use DomainException;
use ReliqArts\CreoleTranslator\Contract\VocabularyException;

abstract class Exception extends DomainException implements VocabularyException
{
}
