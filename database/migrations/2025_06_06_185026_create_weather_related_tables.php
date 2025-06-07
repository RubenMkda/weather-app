<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->timestamps();
        
            $table->index('country_id');
        });
        

        Schema::create('weather_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->timestamp('searched_at')->useCurrent();
            $table->json('weather_data');
            $table->timestamps();
        });

        Schema::create('favorite_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'city_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_cities');
        Schema::dropIfExists('weather_searches');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('countries');
    }
};
