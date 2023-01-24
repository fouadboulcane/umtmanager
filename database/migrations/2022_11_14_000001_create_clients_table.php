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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->unsignedMediumInteger('zipcode');
            $table->string('website')->nullable();
            $table->string('tva_number');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('rc');
            $table->string('nif');
            $table->string('art');
            $table->boolean('online_payment')->default(1);

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
        Schema::dropIfExists('clients');
    }
};
