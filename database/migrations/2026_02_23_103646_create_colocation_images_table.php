<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colocation_images', function (Blueprint $table) {
            $table->id();
            
            // Hna foreign key
            $table->foreignId('colocation_id')
                  ->constrained('colocations') // tsawb foreign key li katreferi 'colocations.id'
                  ->onDelete('cascade');

            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colocation_images');
    }
};