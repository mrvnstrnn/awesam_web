<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->string('invitation_code');
            $table->string('mode');
            $table->unsignedBigInteger('company_id');

            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->integer('use')->default(0);

            $table->string('token');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->primary(['invitation_code', 'company_id']);
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
        Schema::dropIfExists('invitations');
    }
}
