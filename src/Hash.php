<?php

namespace BitMaelum\Core;

use BitMaelum\Core\Exception\HashException;

class Hash
{
    protected const EMPTY_HASH = "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855";

    /** @var string */
    protected $hash;

    /**
     * @param string $hash
     * @return Hash
     */
    public static function direct(string $hash)
    {
        $hash = strtolower($hash);
        if (!preg_match("/^[a-z0-9]{64}$/", $hash)) {
            throw HashException::invalidHash();
        }

        return new self($hash);
    }

    /**
     * @param string $data
     * @return self
     */
    public static function fromData(string $data): self
    {
        return new self(hash("sha256", $data));
    }

    /**
     * Hash constructor.
     * @param string $hash
     */
    protected function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->hash == self::EMPTY_HASH;
    }

    /**
     * @param Hash $localHash
     * @param Hash $orgHash
     * @return bool
     */
    public function verify(Hash $localHash, Hash $orgHash): bool
    {
        $target = self::fromData($localHash . $orgHash);

        return hash_equals($target->getHash(), $this->hash);
    }
}
