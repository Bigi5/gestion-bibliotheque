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
    Schema::table('borrows', function (Blueprint $table) {
        $table->unsignedBigInteger('borrower_profile_id')->nullable(); // Colonne pour lier le profil d'emprunteur
        $table->foreign('borrower_profile_id')->references('id')->on('borrower_profiles')->onDelete('set null'); // Clé étrangère
    });
}

public function down()
{
    Schema::table('borrows', function (Blueprint $table) {
        $table->dropForeign(['borrower_profile_id']);
        $table->dropColumn('borrower_profile_id');
    });
}

};
