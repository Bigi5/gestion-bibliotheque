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
        // Si vous n'utilisez plus `user_id`, vous pouvez supprimer cette colonne
        $table->dropColumn('user_id');
        
        // S'assurer que la colonne `borrower_profile_id` existe et est correctement définie
        $table->unsignedBigInteger('borrower_profile_id')->nullable()->after('book_id');

        // Optionnel : Si vous voulez ajouter une contrainte de clé étrangère
        $table->foreign('borrower_profile_id')->references('id')->on('borrower_profiles')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('borrows', function (Blueprint $table) {
        // Rétablir la colonne `user_id` si nécessaire
        $table->unsignedBigInteger('user_id')->after('book_id');
        
        // Supprimer `borrower_profile_id`
        $table->dropColumn('borrower_profile_id');

        // Optionnel : Supprimer la contrainte de clé étrangère si vous en avez ajouté
        $table->dropForeign(['borrower_profile_id']);
    });
}

};
