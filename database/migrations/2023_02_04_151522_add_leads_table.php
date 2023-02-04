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
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('responsible_user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('account_id')->unsigned();
            $table->integer('pipeline_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('closest_task_at')->nullable();
            $table->integer('price')->unsigned();
            $table->integer('loss_reason_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('leads');
    }
};
