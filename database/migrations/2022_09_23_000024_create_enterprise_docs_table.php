<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseDocsTable extends Migration
{
    public function up()
    {
        Schema::create('enterprise_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
