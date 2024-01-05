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
        Schema::create('aliases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('alias', 255)->index();
            $table->foreignUuid('fund_id')->constrained('funds');
            $table->timestamps();
        });
    }
};
