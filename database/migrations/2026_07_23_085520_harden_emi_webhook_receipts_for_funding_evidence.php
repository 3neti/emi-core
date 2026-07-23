<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webhook_receipts', function (Blueprint $table): void {
            $table->char('deduplication_key', 64)->nullable()->unique();
            $table->string('provider_event_id', 191)->nullable()->index();
            $table->char('body_sha256', 64)->nullable()->index();
            $table->string('content_type', 191)->nullable();
            $table->longText('signature_ciphertext')->nullable();
            $table->longText('raw_body')->nullable();
            $table->longText('headers')->nullable();
            $table->string('source_ip', 45)->nullable();
            $table->string('authentication_status', 32)->default('unverified')->index();
            $table->timestampTz('received_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('webhook_receipts', function (Blueprint $table): void {
            $table->dropColumn([
                'deduplication_key',
                'provider_event_id',
                'body_sha256',
                'content_type',
                'signature_ciphertext',
                'raw_body',
                'headers',
                'source_ip',
                'authentication_status',
                'received_at',
            ]);
        });
    }
};
