<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlogpostsTableble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogposts',function (Blueprint $table){
            $table->string("title")->default('');
            if (env('DB_CONNECTION') === 'sqlite_testing'){

                $table->text("content")->default('');  //add the default value for the test only and remove it as it won't work otherwise as it's text type
            }else{

                $table->text("content");
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("blogposts",function (Blueprint  $table){
            $table->dropColumn(["title","content"]);
        });
    }
}
