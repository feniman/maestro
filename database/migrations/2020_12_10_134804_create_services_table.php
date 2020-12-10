<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('host', 128);
            $table->string('app_key', 128);
            $table->string('app_name', 128);
            $table->string('service_key', 128);
            $table->string('remote_addr', 128);
            $table->tinyInteger('status')->comment('0=Inactive, 1=Active, 2=Draft, 3=Trash');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
