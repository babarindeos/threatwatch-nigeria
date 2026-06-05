<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
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
            $table->string('title', 255);
            $table->text('description');
            $table->unsignedInteger('casualties')->default(0);
            $table->unsignedInteger('kidnapped_count')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->json('evidence_files')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('reporter_name', 150)->nullable();
            $table->string('reporter_phone', 20)->nullable();
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('state_id');
            $table->index('user_id');
            $table->index('attack_type');
            $table->index('incident_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
