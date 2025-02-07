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
        $table->date('due_date')->nullable()->after('return_date'); // Ajout de la colonne "Date prévue de retour"
    });
}

public function down()
{
    Schema::table('borrows', function (Blueprint $table) {
        $table->dropColumn('due_date'); // Suppression de la colonne en cas de rollback
    });
}

};
