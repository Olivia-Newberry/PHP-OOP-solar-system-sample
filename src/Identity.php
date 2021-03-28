<?php

namespace SolarSystem;

use Ramsey\Uuid\Uuid;

final class Identity
{
    public function __construct(string $value)
    {
        $this->value = Uuid::fromString($value);
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
