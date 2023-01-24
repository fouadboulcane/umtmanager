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
        Schema::create('devis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('tax', ['dt', 'tva_19%', 'tva_9%'])->nullable();
            $table->enum('tax2', ['dt', 'tva_19%', 'tva_9%'])->nullable();
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->enum('status', ['accepted', 'denied', 'draft', 'sent']);

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
        Schema::dropIfExists('devis');
    }
};
