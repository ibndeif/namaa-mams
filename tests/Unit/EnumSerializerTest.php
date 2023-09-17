<?php

namespace Tests\Unit;

use App\Enum\EnumSerializer;
use PHPUnit\Framework\TestCase;

enum TestEnum: string
{
    use EnumSerializer;

    case Word = 'word';
    case TwoWords = 'two-words';
    case MoreThanTwoWords = 'more-than-two-words';
}

class EnumSerializerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_EnumSerializer_ForSelectInput(): void
    {
        $result = TestEnum::toArrayForSelectInput();
        $this->assertEquals([
            'word' => 'Word',
            'two-words' => 'Two Words',
            'more-than-two-words' => 'More Than Two Words'
        ], $result);
    }
}
