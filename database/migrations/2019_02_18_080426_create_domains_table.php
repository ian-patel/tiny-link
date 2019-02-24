<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('created_by_id')->index()->nullable();

            $table->string('name')->index();
            $table->string('scheme')->nullable();
            $table->string('host')->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('is_active')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
