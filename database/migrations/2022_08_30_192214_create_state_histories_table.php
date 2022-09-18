<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateHistoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('state_histories', function (Blueprint $table) {
            $table->id();

            $table->morphs('model');
            $table->string('field');

            $table->string('from')->nullable();
            $table->string('to')->nullable();

            $table->json('custom_properties')->nullable();
            $table->nullableMorphs('responsible');

            $table->json('changed_attributes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('state_histories');
    }
}