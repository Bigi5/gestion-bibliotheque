<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();  // Ajoute une colonne 'id' auto-incrémentée
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');
            $table->timestamps();
        });
    }
     

    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Annuler la modification si nécessaire
            $table->dropColumn('id');
            $table->string('id', 191)->primary()->change();
        });
    }
}
