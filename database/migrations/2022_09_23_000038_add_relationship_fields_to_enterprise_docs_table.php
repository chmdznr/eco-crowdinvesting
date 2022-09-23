<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEnterpriseDocsTable extends Migration
{
    public function up()
    {
        Schema::table('enterprise_docs', function (Blueprint $table) {
            $table->unsignedBigInteger('umkm_id')->nullable();
            $table->foreign('umkm_id', 'umkm_fk_7364560')->references('id')->on('enterprises');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7364567')->references('id')->on('users');
        });
    }
}
