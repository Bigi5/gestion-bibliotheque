<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrows', function (Blueprint $table) {
            // Si vous n'utilisez plus `user_id`, vous pouvez supprimer cette colonne
            $table->dropColumn('user_id');
            
            // S'assurer que la colonne `borrower_profile_id` existe et est correctement définie
            $table->unsignedBigInteger('borrower_profile_id')->nullable()->after('book_id');

            // Ajouter une contrainte de clé étrangère
            $table->foreign('borrower_profile_id')->references('id')->on('borrower_profiles')->onDelete('cascade');
        });

        // Ajout de la contrainte unique si elle n'existe pas déjà
        Schema::table('borrows', function (Blueprint $table) {
            $table->unique(['borrower_profile_id', 'book_id', 'return_date'], 'unique_borrow');
        });

        // Ajout du trigger pour limiter les livres empruntés
        DB::statement('
            CREATE TRIGGER limit_borrowed_books
            BEFORE INSERT ON borrows
            FOR EACH ROW
            BEGIN
                DECLARE borrowed_books INT;
                SET borrowed_books = (SELECT COUNT(*) FROM borrows WHERE borrower_profile_id = NEW.borrower_profile_id AND return_date IS NULL);
                IF borrowed_books >= 3 THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Limite de 3 livres empruntés non retournés atteinte";
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrows', function (Blueprint $table) {
            // Rétablir la colonne `user_id` si nécessaire
            $table->unsignedBigInteger('user_id')->after('book_id');
            
            // Supprimer `borrower_profile_id`
            $table->dropColumn('borrower_profile_id');

            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['borrower_profile_id']);
        });

        // Supprimer le trigger
        DB::statement('DROP TRIGGER IF EXISTS limit_borrowed_books');
    }
};
