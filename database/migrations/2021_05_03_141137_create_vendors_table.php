<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('vendor_id');
            $table->string('vendor_fullname');
            $table->string('vendor_admin_email');
            $table->unsignedBigInteger('vendor_program_id');
            $table->foreign('vendor_program_id')->references('vendor_program_id')->on('vendor_programs')->onDelete('cascade');
            $table->string('vendor_sec_reg_name');
            $table->string('vendor_acronym');
            $table->string('vendor_office_address');
            $table->boolean('vendor_saq_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
