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
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('copies_available'); // Suppression de la colonne copies_available
        $table->string('status')->default('available'); // Ajouter la colonne status
    });
}

public function down()
{
    Schema::table('books', function (Blueprint $table) {
        $table->integer('copies_available'); // Ajouter de nouveau la colonne copies_available (si nécessaire)
        $table->dropColumn('status');
    });
}

};
