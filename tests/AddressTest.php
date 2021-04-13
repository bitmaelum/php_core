<?php

namespace BitMaelum\Core\Tests;

use BitMaelum\Core\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase {

    public function addressProvider1(): array
    {
        return [
                ["jay!"],
                ["jay@org!"],
                ["ja.y@org!"],
                ["j.a.y@org!"],
                ["j.a.y@o..rg!"],
                ["j.a.y@o..r---g!"],
                ["j1234!"],
                ["1ja!"],
                ["abc@de!"],
                ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay!"],
                ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay@yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay!"],
        ];
    }

    public function addressProvider2(): array
    {
        return [
            ["jay"],
            ["j!"],
            ["ja!"],
            ["1!"],
            ["jay-@o\$rg!"],
            ["@@org!"],
            ["@org!"],
            ["ab@de!"],
            ["abc@d!"],
            ["jay"],
            ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayx!"],
            ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay1@yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay1!"],
            ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay1@yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay!"],
            ["yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay@yjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjayjay1!"],
        ];
    }

    /**
     * @dataProvider addressProvider1
     * @param string $address
     */
    function testValidAddress(string $address)
    {
        $this->assertTrue(Address::isValid($address));
    }

    /**
     * @dataProvider addressProvider2
     * @param string $address
     */
    function testInvalidAddress(string $address)
    {
        $this->assertFalse(Address::isValid($address));
    }

    function testParts() {
        $addr = Address::fromString("john@example!");
        $this->assertEquals("john", $addr->getLocalPart());
        $this->assertEquals("example", $addr->getOrgPart());
        $this->assertEquals("96d9632f363564cc3032521409cf22a852f2032eec099ed5967c0d000cec607a", $addr->getLocalHash());
        $this->assertEquals("50d858e0985ecc7f60418aaf0cc5ab587f42c2570a884095a9e8ccacd0f6545c", $addr->getOrgHash());
        $this->assertTrue($addr->hashOrganisationPart());
        $this->assertEquals("16d0a463eb0be0514246e65b6b2d74c96d876bd1531f3bc095ac4b9f0b26d71c", $addr->getHash());

        $addr = Address::fromString("john!");
        $this->assertEquals("john", $addr->getLocalPart());
        $this->assertEquals("", $addr->getOrgPart());
        $this->assertFalse($addr->hashOrganisationPart());
        $this->assertEquals("41141d23ae5b3f0a6c027c98dc6e32c02cb079eebf3f2111e565a48139dc01bc", $addr->getHash());
    }
}
