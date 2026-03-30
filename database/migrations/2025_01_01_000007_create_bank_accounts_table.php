<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider_bank_account_id')->nullable()->index();
            $table->string('bank_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number_masked')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_registered')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->string('pmethod')->nullable();
            $table->string('pchannel')->nullable();
            $table->json('payment_action_info')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->json('sender_details')->nullable();
            $table->string('originating_flow')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('cash_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('otp_status')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('cashout_mode')->default('registered_bank_account');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('otp_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_out_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedInteger('attempt_count')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_challenges');
        Schema::dropIfExists('cash_outs');
        Schema::dropIfExists('cash_ins');
        Schema::dropIfExists('bank_accounts');
    }
};
