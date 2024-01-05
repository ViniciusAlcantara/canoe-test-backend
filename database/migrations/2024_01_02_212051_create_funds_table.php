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
        Schema::create('funds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->index();
            $table->integer('start_year')->index();
            $table->boolean('duplicated')->index();
            $table->foreignUuid('fund_manager_id')->constrained('fund_managers');
            $table->timestamps();
        });
    }
};
