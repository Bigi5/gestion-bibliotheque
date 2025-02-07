<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');  // Prénom
            $table->string('last_name');   // Nom
            $table->string('email')->unique(); // Email
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
    
};
