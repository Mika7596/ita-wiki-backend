<?php

declare (strict_types= 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('github_id')->unsigned();
            $table->foreign('github_id')
                ->references('github_id')
                ->on('roles')
                ->onUpdate('cascade') // Updates if github_id is modified in roles
                ->onDelete('restrict'); // Stays if github_id is destroyed in roles
            $table->bigInteger('resource_id')->unsigned();
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
                ->onUpdate('cascade') // Updates if resource_id is modified in resources
                ->onDelete('restrict'); // Stays if resource_id is destroyed in resources
            $table->tinyInteger('like_dislike')->comment('1=like, -1=dislike'); // Stores like or dislike
            $table->timestamps();

            $table->unique(['github_id', 'resource_id']); // Prevent duplicate likes/dislikes per user-resource pair
        });

        // Add triggers to maintain like_count in resources table
        DB::unprepared('
            CREATE TRIGGER update_like_count_insert 
            AFTER INSERT ON likes 
            FOR EACH ROW 
            UPDATE resources 
            SET like_count = like_count + NEW.like_dislike 
            WHERE id = NEW.resource_id;

            CREATE TRIGGER update_like_count_delete 
            AFTER DELETE ON likes 
            FOR EACH ROW 
            UPDATE resources 
            SET like_count = like_count - OLD.like_dislike 
            WHERE id = OLD.resource_id;

            CREATE TRIGGER update_like_count_update 
            AFTER UPDATE ON likes 
            FOR EACH ROW 
            UPDATE resources 
            SET like_count = like_count + (NEW.like_dislike - OLD.like_dislike) 
            WHERE id = NEW.resource_id;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
        DB::unprepared('DROP TRIGGER IF EXISTS update_like_count_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS update_like_count_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS update_like_count_update');
    }
};
