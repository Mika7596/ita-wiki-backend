<?php

declare (strict_types= 1);

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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('github_id')->unique()->nullable(false);
            $table->foreign('id_github')
                ->references('github_id')
                ->on('roles')
                ->onUpdate('cascade') // Updates if github_id is modified in roles
                ->onDelete('restrict'); // Stays if github_id is destroyed in roles
            $table->string('title')->nullable(false);
            $table->string('description');
            $table->string('url')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
