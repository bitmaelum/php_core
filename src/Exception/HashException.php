<?php

namespace BitMaelum\Core\Exception;

class HashException extends BitMaelumException
{
    public static function invalidHash(): self
    {
        return new self("invalid hash. Needs a sha256 hash format");
    }
}
