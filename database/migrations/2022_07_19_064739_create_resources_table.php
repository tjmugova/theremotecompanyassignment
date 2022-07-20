<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->enum('resource_type', ['pdf', 'html', 'link']);
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->text('html')->nullable();
            $table->text('link')->nullable();
            $table->tinyInteger('open_in_new_tab')->default(0);
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
        Schema::dropIfExists('resources');
    }
};
