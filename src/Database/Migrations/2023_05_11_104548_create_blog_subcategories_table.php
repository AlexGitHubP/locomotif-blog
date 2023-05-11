<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_subcategories', function (Blueprint $table) {
            $table->bigIncrements('id', )->length(10);
            $table->unsignedBigInteger('category_id');
            $table->string       ('subcategory_name', 255);
            $table->string       ('subcategory_url' , 255);
            $table->text         ('subcategory_description', 255);
            $table->integer      ('ordering' )->length(10)->unsigned()->nullable();
            $table->enum         ('status', array('hidden', 'published'));
            $table->dateTime     ('created_at');
            $table->dateTime     ('updated_at');

            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_subcategories');
    }
}
