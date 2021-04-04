<?php

namespace SolarSystem;

use Ramsey\Uuid\Uuid;

final class Identity
{
    public function __construct(string $value=null)
    {
        if (!$value)//if value is null, generate a value
        {
            $value = $this->generate();
        }
        //correct format for a UUIDv4
        $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        if (preg_match($UUIDv4, $value)) //use if the value matches the correct format (user or generated)
        {
            $this->value = Uuid::fromString($value);
        }
        else 
        {
            throw new \InvalidArgumentException('Invalid UUID string: '.$value);
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