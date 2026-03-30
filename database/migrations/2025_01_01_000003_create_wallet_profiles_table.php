<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no', 12)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('nationality')->nullable();
            $table->string('source_of_funds')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tin', 15)->nullable();
            $table->string('website', 100)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_profiles');
    }
};
