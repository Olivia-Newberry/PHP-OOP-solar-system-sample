<?php

namespace SolarSystem;

use Ramsey\Uuid\Uuid;

final class Identity
{
    public function __construct(string $value=null)
    {
        if ($value) {
            $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
            if (preg_match($UUIDv4, $value)) {
                $this->value = Uuid::fromString($value);
            } else {
                throw new \InvalidArgumentException('Invalid UUID string: '.$value);
            }
        } else {
            $this->value = $this->generate();
        }
    }

    public static function generate(): Identity
    {
        return new static((string) Uuid::uuid4());
    }

    public function __toString(): string
    {
        return $this->value;
    }
}