<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->index();
            $table->unsignedBigInteger('domain_id')->index();
            $table->unsignedBigInteger('account_id')->index();
            $table->unsignedBigInteger('created_by_id')->index()->nullable();
            $table->string('title')->comment("Url title")->nullable();
            $table->mediumText('link');
            $table->string('slug')->nullable()->index();
            $table->string('source')->nullable();
            $table->string('hostname')->nullable();
            $table->string('hash')->nullable();
            $table->integer('clicks')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('domain_id')->references('id')->on('domains');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
