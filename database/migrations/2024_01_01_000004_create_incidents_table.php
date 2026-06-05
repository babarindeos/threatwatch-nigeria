<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('state_id')->constrained('states')->restrictOnDelete();
            $table->foreignId('lga_id')->nullable()->constrained('lgas')->nullOnDelete();
            $table->string('town', 200)->nullable();
            $table->enum('attack_type', [
                'banditry',
                'terrorism',
                'kidnapping',
                'armed_robbery',
                'communal_clash',
                'herdsmen_attack',
                'cult_clash',
                'cybercrime',
                'police_brutality',
                'fire_outbreak',
                'other',
            ]);
            $table->text('description');
            $table->unsignedInteger('casualties')->default(0);
            $table->unsignedInteger('kidnapped_count')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('source_url', 500)->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_anonymous')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Performance indexes
            $table->index('status');
            $table->index('attack_type');
            $table->index('severity');
            $table->index('incident_date');
            $table->index('state_id');
            $table->index('lga_id');
            $table->index('created_by');
            $table->index(['status', 'severity']);
            $table->index(['latitude', 'longitude']);
            $table->index(['status', 'incident_date']);

            // Full-text search
            $table->fullText(['title', 'description', 'town']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
