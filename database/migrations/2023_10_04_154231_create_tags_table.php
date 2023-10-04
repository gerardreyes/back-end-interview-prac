<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Part 4:
   Currently, the "tags" field in the form doesn't do anything. We would like to create tags for new products:
   Create a new Tag model, and a new pivot table to link the Products to the Tags (many-to-many).
   Take the tags string when the form is submitted and split it by commas.
   Create a tag for each save it - but only if it's unique.
   Link the product to each one (whether the tags were new or existed from before).
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
