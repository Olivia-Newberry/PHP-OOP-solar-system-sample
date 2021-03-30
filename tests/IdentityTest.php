<?php

namespace SolarSystem;

use PHPUnit\Framework\TestCase;

class IdentityTest extends TestCase
{
    public function test_can_hydrate_from_existing_value()
    {
        $id = new Identity("44260076-3856-46ed-88d5-9946c093e6d7");

        $this->assertInstanceOf(Identity::class, $id);
        $this->assertEquals("44260076-3856-46ed-88d5-9946c093e6d7", (string) $id);
    }

    public function test_it_must_be_of_valid_uuid_4_format()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid UUID string: monkey');

        new Identity("monkey");
    }

    public function test_can_generate_valid_UUID()
    {
        $id = new Identity;
        $this->assertInstanceOf(Identity::class, $id);

        $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $test = preg_match($UUIDv4, (string) $id);
        $this->assertEquals(1, $test);
    }
}
