<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParksTable extends Migration
{

    public function up()
    {
        Schema::create('parks', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('vacancy_id')->unsigned();
            $table->string('cpf',14);
            $table->string('timeIn',8);
            $table->string('timeOut',8)->default("00:00:00");
            $table->string('model',20);
            $table->string('board',10);
            $table->timestamps();

            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('parks');
    }
}
