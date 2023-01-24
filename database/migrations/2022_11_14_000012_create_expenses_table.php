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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->decimal('amount');
            $table->date('date');
            $table->enum('category', ['miscellaneous_expense']);
            $table->enum('tax', ['dt', 'tva_19%', 'tva_9%']);
            $table->enum('tax2', ['dt', 'tva_19%', 'tva_9%']);
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');

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
        Schema::dropIfExists('expenses');
    }
};
