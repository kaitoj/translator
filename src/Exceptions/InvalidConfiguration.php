<?php

namespace Kaitoj\Translator\Exceptions;

use Exception;
use Kaitoj\Translator\Translation;

class InvalidConfiguration extends Exception
{
    public static function invalidModel(string $className): self
    {
        return new static("You have configured an invalid class `{$className}`.".
            'A valid class extends '.Translation::class.'.');
    }
}
