<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->string('salary')->nullable();
            $table->string('conditions')->nullable();
            $table->integer('n_ss')->nullable();
            $table->date('recruitment_date')->nullable();
            $table->boolean('send_info')->default(0);
            $table->unsignedBigInteger('team_member_id')->nullable();
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
        Schema::dropIfExists('team_members');
    }
};
