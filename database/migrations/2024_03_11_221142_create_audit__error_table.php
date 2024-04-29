<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_error', function (Blueprint $table) {
            $table->unsignedBigInteger('error_id');
            $table->unsignedBigInteger('audit_id');
            $table->timestamps();

            $table->foreign('error_id')->references('id')->on('errors');
            $table->foreign('audit_id')->references('id')->on('audits');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_error');
    }
}
