<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('factures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
    $table->decimal('total', 10, 2);
    $table->dateTime('date_paiement');
    $table->enum('mode_paiement', ['espece', 'carte'])->default('espece');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
