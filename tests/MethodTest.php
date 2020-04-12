<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Method;

class MethodTest extends TestCase
{
    public function test_instance()
    {
        $method = new Method('run', ['foo', 'bar']);
        $this->assertInstanceOf('Recca0120\Repository\Method', $method);
        $this->assertSame('run', $method->name);
        $this->assertSame(['foo', 'bar'], $method->parameters);
    }
}
