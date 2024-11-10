<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            // Auto-incrementing ID starting from 111 (optional)
            $table->increments('id')->unsigned()->from(111);

            // Employee-specific fields
            $table->string('name');
            $table->string('position');
            $table->string('email')->nullable()->unique();
            $table->string('pin_code')->nullable();
            $table->text('permissions')->nullable();  // Ensure how permissions are used in your app
            $table->timestamp('email_verified_at')->nullable();  // For email verification
            $table->rememberToken();  // For "remember me" functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
