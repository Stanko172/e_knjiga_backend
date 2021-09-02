<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_card', function (Blueprint $table) {
            $table->id('card_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('password');
            $table->boolean('is_ot_password');
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
        Schema::dropIfExists('membership_card');
    }
}
