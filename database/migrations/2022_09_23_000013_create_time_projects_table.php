<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('time_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable()->unique();
            $table->string('name')->nullable();
            $table->decimal('biaya_diajukan', 15, 2)->nullable();
            $table->decimal('biaya_terpenuhi', 15, 2)->nullable();
            $table->string('remote_device')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
