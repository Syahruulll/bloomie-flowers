<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admins') && ! Schema::hasTable('products')) {
            Schema::rename('admins', 'products');
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'title')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->renameColumn('title', 'name');
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'photo')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->string('photo')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'name')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->renameColumn('name', 'title');
            });
        }

        if (Schema::hasTable('products') && ! Schema::hasTable('admins')) {
            Schema::rename('products', 'admins');
        }
    }
};
