<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('helplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('lga_id')->nullable()->constrained('lgas')->nullOnDelete();
            $table->string('agency_name');
            $table->string('phone', 50);
            $table->string('phone_alt', 50)->nullable();
            $table->enum('category', [
                'police',
                'fire',
                'ambulance',
                'frsc',
                'dss',
                'civil_defence',
                'military',
                'nema',
                'ngo',
                'other',
            ])->default('other');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_national')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('state_id');
            $table->index('lga_id');
            $table->index('category');
            $table->index('is_active');
            $table->index('is_national');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('helplines');
    }
};
