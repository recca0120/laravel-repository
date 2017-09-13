<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Method;

class MethodTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testInstance()
    {
        $method = new Method('run', ['foo', 'bar']);
        $this->assertInstanceOf('Recca0120\Repository\Method', $method);
        $this->assertSame('run', $method->name);
        $this->assertSame(['foo', 'bar'], $method->parameters);
    }
}
