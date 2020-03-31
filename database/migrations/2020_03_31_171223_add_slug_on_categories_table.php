<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddSlugOnCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table
                ->string('slug')
                ->after('title');
        });

        $this->updateSlugs();

        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    private function updateSlugs(): void
    {
        $categories = DB::table('categories')->select(['id', 'title'])->get();

        foreach ($categories as $category) {
            $slug = Str::slug($category->title . ' ' . $category->id);
            DB::table('categories')
                ->where('id', '=', $category->id)
                ->update(['slug' => $slug]);
        }
    }
}
