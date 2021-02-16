<?php

namespace Rrvwmrrr\Auditor\Exceptions;

use Exception;

class AuditException extends Exception
{
    public static function eventNotCovered(string $event): self
    {
        return new static("The auditor does not cover the `{$event}` event you've requested");
    }
}
