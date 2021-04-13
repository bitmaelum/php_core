<?php

namespace BitMaelum\Core\Exception;

class OtpException extends BitMaelumException
{
    public static function cannotGenerate(): self
    {
        return new self("cannot generate otp code");
    }
}
