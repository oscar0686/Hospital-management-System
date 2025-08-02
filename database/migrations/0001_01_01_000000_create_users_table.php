<?php
// database/migrations/2024_01_01_000001_add_additional_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('gender');
            $table->string('profile_photo')->nullable()->after('address');
            $table->boolean('is_active')->default(true)->after('profile_photo');

            // Modify existing name column to be nullable since we're using first_name and last_name
            $table->string('name')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'phone', 'date_of_birth',
                'gender', 'address', 'profile_photo', 'is_active'
            ]);
            $table->string('name')->nullable(false)->change();
        });
    }
};