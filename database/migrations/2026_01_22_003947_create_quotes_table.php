<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('opportunity_id')->constrained('opportunities')->restrictOnDelete();

            $table->string('quote_number', 50)->unique();
            $table->date('issued_at');
            $table->date('valid_until')->nullable();

            $table->string('currency', 10)->default('ARS');
            $table->decimal('total', 14, 2)->default(0);

            $table->string('pdf_path', 255)->nullable();
            $table->string('status', 30)->default('emitida'); // emitida/aceptada/rechazada/anulada

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['opportunity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
