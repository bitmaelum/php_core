<?php

namespace BitMaelum\Core\Tests;

use BitMaelum\Core\Exception\HashException;
use BitMaelum\Core\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase {

    function testHash()
    {
        $h = Hash::fromData("foobar");
        $this->assertEquals("c3ab8ff13720e8ad9047dd39466b3c8974e592c2fa383d4a3960714caef0c4f2", $h->getHash());
        $this->assertFalse($h->isEmpty());

        $h = Hash::fromData("");
        $this->assertEquals("e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855", $h->getHash());
        $this->assertTrue($h->isEmpty());

        $h = Hash::fromData("foobar");
        $this->assertEquals("c3ab8ff13720e8ad9047dd39466b3c8974e592c2fa383d4a3960714caef0c4f2", (string)$h);
    }

    function testDirect()
    {
        $h = Hash::direct("16d0a463eb0be0514246e65b6b2d74c96d876bd1531f3bc095ac4b9f0b26d71c");
        $this->assertEquals("16d0a463eb0be0514246e65b6b2d74c96d876bd1531f3bc095ac4b9f0b26d71c", $h);

        $this->expectException(HashException::class);
        Hash::direct("foobar");
    }

    function testVerify()
    {
        // address hash for john@example!
        $h = Hash::direct("16d0a463eb0be0514246e65b6b2d74c96d876bd1531f3bc095ac4b9f0b26d71c");

        $lh = Hash::fromData("john");
        $oh = Hash::fromData("example");
        $this->assertTrue($h->verify($lh, $oh));

        $lh2 = Hash::fromData("jane");
        $this->assertFalse($h->verify($lh2, $oh));
    }

}
