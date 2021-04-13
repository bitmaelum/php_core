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
}
