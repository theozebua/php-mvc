<?php

namespace Tests\Unit;

use App\Core\Config\DotEnv;
use PHPUnit\Framework\TestCase;
use App\Core\Migrations\UserMigration;

(new DotEnv(__DIR__ . DIRECTORY_SEPARATOR . '../../app/.env'))->load();

final class UserMigrationTest extends TestCase
{
    /**
     * Migration up test
     */
    public function test_if_user_migration_up_is_success(): void
    {
        $this->assertTrue((new UserMigration)->up());
    }

    /**
     * Migration down test
     */
    public function test_if_user_migration_down_is_success(): void
    {
        $this->assertTrue((new UserMigration)->down());
    }
}
