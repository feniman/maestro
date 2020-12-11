<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemoteAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remote_addresses', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('part1', 3);
            $table->string('part2', 3);
            $table->string('part3', 3);
            $table->string('part4', 3);
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
        Schema::dropIfExists('remote_addresses');
    }
}
