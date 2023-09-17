<?php

namespace Tests\Unit;

use App\Enum\ArticleStatus;
use PHPUnit\Framework\TestCase;

class ArticleStatusTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_article_status_enum_cases_names_must_be_in_pascal_case(): void
    {
        $cases = ArticleStatus::cases();
        foreach ($cases as $case) {
            $this->assertMatchesRegularExpression('/^[A-Z][a-zA-Z]*$/', $case->name);
        }
    }
}
