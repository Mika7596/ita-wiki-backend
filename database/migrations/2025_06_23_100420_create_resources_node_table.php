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
        Schema::create('resources_node', function (Blueprint $table) {
            $table->id();
            $table->string('node_id');  // fk to roles_id

            $table->foreign('node_id')
            ->references('node_id')
            ->on('roles_node')
            ->onUpdate('cascade') // Updates if node_id is modified in roles
            ->onDelete('restrict'); // Stays if node_id is destroyed in roles

            $table->string('title');
            $table->string('description')->nullable();
            $table->string('url');
            $table->enum('category', ['Node', 'React', 'Angular', 'JavaScript', 'Java', 'Fullstack PHP', 'Data Science', 'BBDD']);
            $table->json('tags')->nullable(); // Options must be restricted in Form Request (as defined in table tags)
            $table->enum('type', ['Video', 'Cursos', 'Blog']);
            $table->integer('bookmark_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources_node');
    }
};
