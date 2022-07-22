<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Method;

class MethodTest extends TestCase
{
    public function test_instance()
    {
        $method = new Method('run', ['foo', 'bar']);
        $this->assertInstanceOf(Method::class, $method);
        $this->assertEquals('run', $method->name);
        $this->assertEquals(['foo', 'bar'], $method->parameters);
    }
}
