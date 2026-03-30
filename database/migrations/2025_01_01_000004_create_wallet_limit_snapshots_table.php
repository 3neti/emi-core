<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_limit_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->decimal('remaining_wallet_limit', 14, 2)->nullable();
            $table->decimal('remaining_inflow_limit', 14, 2)->nullable();
            $table->decimal('remaining_annual_inflow_limit', 14, 2)->nullable();
            $table->decimal('remaining_outflow_limit', 14, 2)->nullable();
            $table->timestamp('captured_at');
            $table->json('source_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_limit_snapshots');
    }
};
