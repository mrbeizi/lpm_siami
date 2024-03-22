<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileDocumentImplementationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_document_implementations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fdi_name');
            $table->integer('id_document_implementation');
            $table->integer('id_category');
            $table->integer('id_department');
            $table->string('uploaded_file')->nullable();
            $table->string('link')->nullable();
            $table->integer('validate');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('file_document_implementations');
    }
}
