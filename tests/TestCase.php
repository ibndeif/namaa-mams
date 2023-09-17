<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    final public function assertStringInPascalCase(string $string)
    {
        static::assertMatchesRegularExpression('/^[A-Z][a-zA-Z]*$/', $string);
    }
}
