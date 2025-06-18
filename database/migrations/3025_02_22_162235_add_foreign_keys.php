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
        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->foreign('block_type_id')->references('id')->on('block_types');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->foreign('collection_type_id')->references('id')->on('collection_types');
        });

        Schema::table('mediaables', function (Blueprint $table) {
            // $table->foreign('mediaable_id')->references('id')->on('medias')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
        });

        Schema::table('navigations', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

        Schema::table('actions', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('collection_type_id')->references('id')->on('collection_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
