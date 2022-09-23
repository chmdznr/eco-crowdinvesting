<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeProjectUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('time_project_user', function (Blueprint $table) {
            $table->unsignedBigInteger('time_project_id');
            $table->foreign('time_project_id', 'time_project_id_fk_7364537')->references('id')->on('time_projects')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_7364537')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
