<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contact_id')->constrained('contacts')->restrictOnDelete();
            $table->foreignId('assigned_user_id')->constrained('users')->restrictOnDelete(); // Ejecutivo comercial

            $table->string('detail', 255);              // Producto o Detalle
            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('unit', 50)->nullable();     // Medida
            $table->decimal('amount', 14, 2)->nullable(); // Importe

            // Flujo de estado
            $table->string('status', 50)->default('prospecto'); 
            $table->date('opened_at')->nullable();
            $table->date('closed_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
            $table->index(['assigned_user_id']);
            $table->index(['contact_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
