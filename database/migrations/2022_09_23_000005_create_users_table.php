<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('two_factor')->default(0)->nullable();
            $table->string('two_factor_code')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('nik')->nullable();
            $table->boolean('is_nik_valid')->default(0)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->datetime('two_factor_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
