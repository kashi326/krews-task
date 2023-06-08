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
        Schema::create('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('title');
            $table->text('body');
            $table->string('image_path');
            $table->date('publish_date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->primary(['id', 'publish_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
