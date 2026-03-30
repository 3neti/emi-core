<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('provider_code');
            $table->string('event_type')->nullable();
            $table->string('request_id')->nullable()->index();
            $table->string('postback_id')->nullable()->index();
            $table->text('signature')->nullable();
            $table->boolean('signature_verified')->default(false);
            $table->json('payload');
            $table->string('processing_status')->default('received');
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        Schema::create('reconciliation_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider_code');
            $table->string('request_id')->index();
            $table->string('local_status');
            $table->string('provider_status');
            $table->boolean('is_match')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reconciliation_entries');
        Schema::dropIfExists('webhook_receipts');
    }
};
