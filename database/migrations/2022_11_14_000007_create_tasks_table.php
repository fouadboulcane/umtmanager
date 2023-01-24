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
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->enum('difficulty', ['1', '2', '3', '4', '5']);
            $table->unsignedBigInteger('project_id');
            $table->enum('status', ['todo', 'ongoing', 'done', 'closed']);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('member_id');

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
        Schema::dropIfExists('tasks');
    }
};
