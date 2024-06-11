<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('valute_id')->nullable();
            $table->string('num_code')->nullable();
            $table->string('char_code')->nullable();
            $table->unsignedBigInteger('nominal')->nullable();
            $table->string('name')->nullable();
            $table->float('value', 53)->nullable();
            $table->float('vunit_rate', 53)->nullable();
            $table->date('date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->index('valute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
