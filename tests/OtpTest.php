<?php

namespace BitMaelum\Core\Tests;

use BitMaelum\Core\Otp;
use PHPUnit\Framework\TestCase;

class OtpTest extends TestCase {

    function testOtp()
    {
        $this->assertEquals("10023065", Otp::getCode(1618384000, "secret", 8));
        $this->assertEquals("10023065", Otp::getCode(1618384010, "secret", 8));
        $this->assertEquals("10023065", Otp::getCode(1618384019, "secret", 8));
        $this->assertEquals("02581877", Otp::getCode(1618384020, "secret", 8));
        $this->assertEquals("02581877", Otp::getCode(1618384021, "secret", 8));

        $this->assertEquals("02581877", Otp::getCode(1618384030, "secret", 8));
        $this->assertEquals("24413300", Otp::getCode(1618384030, "something-else", 8));

        $this->assertEquals("01481263", Otp::getCode(1, "secret", 8));
        $this->assertEquals("01481263", Otp::getCode(10, "secret", 8));
        $this->assertEquals("48839665", Otp::getCode(3100, "secret", 8));
    }
}
