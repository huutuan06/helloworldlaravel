<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->bigIncrements('id', 11);
            $table->integer('user_id')->nullable();
            $table->string('token', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
