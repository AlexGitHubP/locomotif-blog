<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogToSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_to_subcategories', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->dateTime          ('created_at');
            $table->dateTime          ('updated_at');

            $table->foreign('blog_id')->references('id')->on('blog')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('blog_subcategories')->onDelete('cascade');

            $table->primary(['blog_id', 'subcategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_to_subcategories');
    }
}
