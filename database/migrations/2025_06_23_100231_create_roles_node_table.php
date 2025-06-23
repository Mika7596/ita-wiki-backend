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
        Schema::create('roles_node', function (Blueprint $table) {
            $table->id();
            $table->string('node_id')->unique();   // node_id replaces github_id
            $table->enum('role', ['superadmin', 'admin', 'mentor', 'student']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_node');
    }
};
