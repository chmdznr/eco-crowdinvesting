<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterprisesTable extends Migration
{
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nib')->unique();
            $table->boolean('is_nib_valid')->default(0)->nullable();
            $table->string('name');
            $table->string('skala_usaha');
            $table->longText('alamat')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
