<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEnterprisesTable extends Migration
{
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_usaha_id')->nullable();
            $table->foreign('jenis_usaha_id', 'jenis_usaha_fk_7364527')->references('id')->on('type_of_businesses');
            $table->unsignedBigInteger('pemilik_id')->nullable();
            $table->foreign('pemilik_id', 'pemilik_fk_7364528')->references('id')->on('users');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7364534')->references('id')->on('users');
        });
    }
}
