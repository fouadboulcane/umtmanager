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
        Schema::create('devi_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('content')->nullable();
            $table->unsignedBigInteger('manifest_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', [
                'pending',
                'canceled',
                'estimated',
                'draft',
            ]);

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
        Schema::dropIfExists('devi_requests');
    }
};
