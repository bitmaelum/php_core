<?php

namespace BitMaelum\Core;

use BitMaelum\Core\Exception\OtpException;

class Otp
{

    /**
     * @param float $time
     * @param string $secret
     * @return string
     * @throws OtpException
     */
    public static function getCode(float $time, string $secret, int $length = 8): string
    {
        $timestamp = (floor(floor($time) / 30) * 30) . "000000000";
        $int64ts = gmp_init($timestamp);
        $int64str = gmp_strval($int64ts, 16);

        // Make sure str is even by padding with 0
        if (strlen($int64str) % 2 == 1) {
            $int64str = "0" . $int64str;
        }
        $timestampBytes = hex2bin($int64str);
        if ($timestampBytes === false) {
            throw OtpException::cannotGenerate();
        }

        $sum = hash_hmac("sha256", $timestampBytes, $secret, true);
        $offset = ord($sum[strlen($sum) - 1]) & 0x0F;

        $a = (int)ord($sum[$offset + 0]) & 0x7F;
        $b = (int)ord($sum[$offset + 1]) & 0xFF;
        $c = (int)ord($sum[$offset + 2]) & 0xFF;
        $d = (int)ord($sum[$offset + 3]) & 0xFF;
        $value = $a << 24 | $b << 16 | $c << 8 | $d;

        // Pad with 0 is too short
        $value = str_pad((string)$value, $length, "0", STR_PAD_LEFT);
        return substr($value, 0 - $length);
    }
}
