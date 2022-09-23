<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOfBusinessesTable extends Migration
{
    public function up()
    {
        Schema::create('type_of_businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
