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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("thumbnail")->nullable();
            $table->string("slug");
            $table->unsignedBigInteger("author_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("author_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
