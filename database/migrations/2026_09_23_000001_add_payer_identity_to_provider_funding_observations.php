<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provider_funding_observations', function (Blueprint $table): void {
            $table->text('payer_name_ciphertext')->nullable();
            $table->text('payer_account_ciphertext')->nullable();
            $table->text('payer_institution_ciphertext')->nullable();
            $table->text('payer_mobile_ciphertext')->nullable();
            $table->string('payer_identity_verification_source', 64)->nullable();
            $table->boolean('payer_identity_provider_verified')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('provider_funding_observations', function (Blueprint $table): void {
            $table->dropColumn([
                'payer_name_ciphertext',
                'payer_account_ciphertext',
                'payer_institution_ciphertext',
                'payer_mobile_ciphertext',
                'payer_identity_verification_source',
                'payer_identity_provider_verified',
            ]);
        });
    }
};
