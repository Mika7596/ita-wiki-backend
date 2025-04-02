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
        Schema::create('bookmarks', function (Blueprint $table) {
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
            $table->timestamps();

            $table->unique(['github_id', 'resource_id']);
        });

        // Increment trigger (AFTER INSERT on bookmarks)
        DB::unprepared('
            CREATE TRIGGER increment_bookmark_count
            AFTER INSERT ON bookmarks
            FOR EACH ROW
            BEGIN
                UPDATE resources
                SET bookmark_count = bookmark_count + 1
                WHERE id = NEW.resource_id;
            END
        ');

        // Decrement trigger (AFTER DELETE on bookmarks)
        DB::unprepared('
            CREATE TRIGGER decrement_bookmark_count
            AFTER DELETE ON bookmarks
            FOR EACH ROW
            BEGIN
                UPDATE resources
                SET bookmark_count = bookmark_count - 1
                WHERE id = OLD.resource_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');

        DB::unprepared('DROP TRIGGER IF EXISTS increment_bookmark_count');
        DB::unprepared('DROP TRIGGER IF EXISTS decrement_bookmark_count');
    }
};
