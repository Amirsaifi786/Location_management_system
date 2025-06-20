<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            // Only keep the foreignId (this includes unsignedBigInteger + foreign key constraint)
            $table->foreignId('state_id')->constrained()->onDelete('cascade');

            $table->string('city_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
