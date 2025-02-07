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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Lien vers l'utilisateur
            $table->timestamp('login_at'); // Heure de connexion
            $table->timestamp('logout_at')->nullable(); // Heure de déconnexion
            $table->timestamps();
    
            // Ajouter une clé étrangère pour assurer l'intégrité des données
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('user_sessions');
    }
    
};
