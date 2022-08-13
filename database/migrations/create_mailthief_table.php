<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mailthief', function (Blueprint $table) {
            $table->id();
            $table->json('from')->nullable();
            $table->json('to')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('subject')->nullable();
            $table->text('text')->nullable();
            $table->longText('html')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }
};
