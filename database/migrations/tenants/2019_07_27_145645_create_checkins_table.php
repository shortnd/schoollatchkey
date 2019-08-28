<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('am_in')->nullable();
            $table->dateTime('pm_in')->nullable();
            $table->dateTime('pm_out')->nullable();
            $table->unsignedInteger('late_fee')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->string('initals')->nullable();
            // TODO: Will add Sig
            // $table->text('pm_sig')->nullable();
            // Relationships
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('children')->onDelete('CASCADE');
            $table->integer('late_fee')->default(0)->max(3);
            $table->dateTime('am_checkin_time')->nullable();
            $table->dateTime('pm_checkin_time')->nullable();
            $table->dateTime('pm_checkout_time')->nullable();
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
        Schema::dropIfExists('checkins');
    }
}
