<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider_code');
            $table->string('provider_wallet_id')->unique();
            $table->string('provider_account_id_value')->nullable()->index();
            $table->string('account_no')->nullable();
            $table->string('external_uid')->nullable()->index();
            $table->string('wallet_type');
            $table->string('status')->default('active');
            $table->string('compliance_level')->default('0');
            $table->string('verification_status')->default('PENDING');
            $table->decimal('balance_cached', 14, 2)->default(0);
            $table->string('currency', 3)->default('PHP');
            $table->string('notification_url')->nullable();
            $table->text('capture_link')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
