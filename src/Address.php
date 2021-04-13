<?php

namespace BitMaelum\Core;

use BitMaelum\Core\Exception\AddressException;

class Address
{
    protected const ADDRESS_REGEX = '|^([a-z0-9][a-z0-9.\-]{1,62}[a-z0-9])(?:@([a-z0-9][a-z0-9.\-]{0,62}[a-z0-9]))?!$|';

    /** @var string */
    protected $localPart;
    /** @var string */
    protected $orgPart;
    /** @var string */
    protected $localHash;
    /** @var string */
    protected $orgHash;

    /**
     * @param string $address
     * @return self
     * @throws AddressException
     */
    public static function fromString(string $address): self
    {
        if (!preg_match(self::ADDRESS_REGEX, $address, $matches)) {
            throw AddressException::InvalidFormat();
        }

        if (count($matches) == 2) {
            $matches[] = "";
        }

        return new self($matches[1], $matches[2]);
    }

    /**
     * Address constructor.
     * @param string $local
     * @param string $org
     */
    protected function __construct(string $local, string $org)
    {
        $this->localPart = $local;
        $this->orgPart = $org;

        $this->localHash = Hash::fromData($this->localPart);
        $this->orgHash = Hash::fromData($this->orgPart);
    }

    /**
     * @param string $address
     * @return bool
     */
    public static function isValid(string $address): bool
    {
        try {
            self::fromString($address);
        } catch (AddressException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    /**
     * @return string
     */
    public function getOrgPart(): string
    {
        return $this->orgPart;
    }

    /**
     * @return string
     */
    public function getLocalHash(): string
    {
        return $this->localHash;
    }

    /**
     * @return string
     */
    public function getOrgHash(): string
    {
        return $this->orgHash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return Hash::fromData($this->localHash . $this->localPart);
    }

    /**
     * @return bool
     */
    public function hashOrganisationPart(): bool
    {
        return $this->orgPart != "";
    }
}
