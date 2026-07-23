<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_funding_observations', function (Blueprint $table): void {
            $table->id();
            $table->char('observation_key', 64)->unique();
            $table->string('provider_code', 64)->index();
            $table->string('provider_transaction_id', 191)->index();
            $table->string('provider_operation_id', 191)->nullable()->index();
            $table->string('request_id', 191)->nullable()->index();
            $table->string('funding_address', 191)->nullable()->index();
            $table->string('provider_account_reference', 191)->nullable();
            $table->unsignedBigInteger('gross_amount_minor');
            $table->unsignedBigInteger('fee_amount_minor')->default(0);
            $table->unsignedBigInteger('net_amount_minor');
            $table->char('currency', 3);
            $table->string('provider_status', 64)->index();
            $table->timestampTz('occurred_at')->nullable();
            $table->timestampTz('settled_at')->nullable();
            $table->string('verification_source', 64);
            $table->foreignId('webhook_receipt_id')
                ->nullable()
                ->constrained('webhook_receipts')
                ->nullOnDelete();
            $table->char('payload_hash', 64);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(
                ['provider_code', 'provider_transaction_id', 'provider_status'],
                'provider_funding_observation_lookup',
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_funding_observations');
    }
};
