<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'supervisor', 'employee', 'user')
            NOT NULL DEFAULT 'user'
        ");

        DB::table('users')
            ->whereIn('role', ['supervisor', 'employee'])
            ->update(['role' => 'user']);

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'user')
            NOT NULL DEFAULT 'user'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'supervisor', 'employee')
            NOT NULL DEFAULT 'employee'
        ");
    }
    
};
