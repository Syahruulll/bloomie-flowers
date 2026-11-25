<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products') && ! Schema::hasTable('admins')) {
            Schema::rename('products', 'admins');
        }

        if (Schema::hasTable('admins') && Schema::hasColumn('admins', 'name') && ! Schema::hasColumn('admins', 'title')) {
            Schema::table('admins', function (Blueprint $table): void {
                $table->renameColumn('name', 'title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admins') && Schema::hasColumn('admins', 'title') && ! Schema::hasColumn('admins', 'name')) {
            Schema::table('admins', function (Blueprint $table): void {
                $table->renameColumn('title', 'name');
            });
        }

        if (Schema::hasTable('admins') && ! Schema::hasTable('products')) {
            Schema::rename('admins', 'products');
        }
    }
};
