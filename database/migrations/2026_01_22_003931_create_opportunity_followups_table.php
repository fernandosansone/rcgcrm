<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunity_followups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('opportunity_id')->constrained('opportunities')->cascadeOnDelete();

            $table->dateTime('contact_date');
            $table->string('contact_method', 50); // tel/email/reunion/whatsapp/etc

            $table->text('response')->nullable();
            $table->dateTime('next_contact_date')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['next_contact_date']);
            $table->index(['opportunity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunity_followups');
    }
};
