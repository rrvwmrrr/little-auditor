<?php

namespace Rrvwmrrr\Auditor\Exceptions;

use Exception;

final class AuditException extends Exception
{
    public static function eventNotCovered(string $event): self
    {
        return new static("The auditor does not cover the `{$event}` event you've requested");
    }
}
