<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_invested_funds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fund_id')->constrained('funds');
            $table->foreignUuid('company_id')->constrained('funds');
            $table->timestamps();
        });
    }
};
