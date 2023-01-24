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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('billing_date');
            $table->date('due_date');
            $table->enum('tax', ['dt', 'tva_19%', 'tva_9%'])->nullable();
            $table->enum('tax2', ['dt', 'tva_19%', 'tva_9%'])->nullable();
            $table->text('note')->nullable();
            $table->boolean('reccurent')->default(0);
            $table->enum('status', ['paid', 'canceled', 'draft', 'late']);
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');

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
        Schema::dropIfExists('invoices');
    }
};
