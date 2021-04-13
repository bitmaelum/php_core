<?php

namespace BitMaelum\Core\Exception;

class AddressException extends BitMaelumException
{
    public static function invalidFormat(): self
    {
        return new self("invalid address format");
    }
}
