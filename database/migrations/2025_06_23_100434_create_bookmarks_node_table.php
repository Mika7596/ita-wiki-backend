<?php

declare(strict_types=1);

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
        Schema::create('bookmarks_node', function (Blueprint $table) {
            $table->id();
            $table->string('node_id');

            $table->foreign('node_id')
                ->references('node_id')
                ->on('roles_node')
                ->onUpdate('cascade') // Updates if node_id is modified in roles
                ->onDelete('restrict'); // Stays if node_id is destroyed in roles

            $table->unsignedBigInteger('resource_node_id');

            $table->foreign('resource_node_id')
                ->references('id')
                ->on('resources_node')
                ->onUpdate('cascade') // Updates if resource_id is modified in resources
                ->onDelete('restrict'); // Stays if resource_id is destroyed in resources
            
                $table->timestamps();

            $table->unique(['node_id', 'resource_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks_node');
    }
};
