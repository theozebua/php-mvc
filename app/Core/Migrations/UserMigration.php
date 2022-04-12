<?php

namespace App\Core\Migrations;

use App\Core\Database\BaseModel;
use App\Core\Interfaces\Migration;

class UserMigration extends BaseModel implements Migration
{
    public function up(): bool
    {
        return $this->createTable('users', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'image' => 'VARCHAR(255)'
        ])->exec();
    }

    public function down(): bool
    {
        return $this->dropTable('users')->exec();
    }
}
