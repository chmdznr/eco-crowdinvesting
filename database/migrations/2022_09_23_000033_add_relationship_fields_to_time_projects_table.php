<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimeProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('time_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('umkm_penyedia_id')->nullable();
            $table->foreign('umkm_penyedia_id', 'umkm_penyedia_fk_7364544')->references('id')->on('enterprises');
            $table->unsignedBigInteger('umkm_penerima_id')->nullable();
            $table->foreign('umkm_penerima_id', 'umkm_penerima_fk_7364545')->references('id')->on('enterprises');
            $table->unsignedBigInteger('mode_investasi_id')->nullable();
            $table->foreign('mode_investasi_id', 'mode_investasi_fk_7364539')->references('id')->on('financial_access_types');
            $table->unsignedBigInteger('mode_pembayaran_id')->nullable();
            $table->foreign('mode_pembayaran_id', 'mode_pembayaran_fk_7364540')->references('id')->on('market_access_types');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_7364543')->references('id')->on('project_statuses');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7364546')->references('id')->on('users');
        });
    }
}
