<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('description', 2000)->nullable();
            $table->string('image')->nullable();
            $table->decimal('buying_price');
            $table->decimal('selling_price');
            $table->unsignedInteger('count');
            $table->enum('category', ['Хранителни стоки', 'Канцеларски материали', 'Строителни материали']);
            $table->string('code')->unique();
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
        Schema::dropIfExists('products');
    }
};
