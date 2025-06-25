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
        Schema::create('likes_node', function (Blueprint $table) {
            $table->id();
            $table->string('node_id');

            $table->foreign('node_id')
                ->references('node_id')
                ->on('roles_node')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unsignedBigInteger('resource_node_id');
            
            $table->foreign('resource_node_id')
                ->references('id')
                ->on('resources_node')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();

            $table->unique(['node_id', 'resource_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes_node');
    }
};
