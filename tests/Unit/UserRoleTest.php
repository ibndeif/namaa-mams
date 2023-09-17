<?php

namespace Tests\Unit;

use App\Enum\UserRole;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_role_enum_cases_names_must_be_in_pascal_case(): void
    {
        $cases = UserRole::cases();
        foreach ($cases as $case) {
            $this->assertStringInPascalCase($case->name);
        }
    }
}
