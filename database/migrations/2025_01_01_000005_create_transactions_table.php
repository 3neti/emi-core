<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('source_wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            $table->foreignId('destination_wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            $table->foreignId('provider_account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider_code');
            $table->string('provider_transaction_id')->nullable()->index();
            $table->string('provider_reference')->nullable();
            $table->string('request_id')->unique();
            $table->string('transaction_type');
            $table->string('direction');
            $table->string('status')->default('initiated');
            $table->decimal('amount', 14, 2);
            $table->decimal('fee', 14, 2)->default(0);
            $table->decimal('final_amount', 14, 2)->nullable();
            $table->string('currency', 3)->default('PHP');
            $table->timestamp('occurred_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
