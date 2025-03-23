<?php

use App\Enums\ProgrammingSkills;
use App\Enums\SkillLevel;
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
        Schema::create('offer_skill', function (Blueprint $table) {
            $table->foreignId('offer_id')
                ->constrained('offers')
                ->cascadeOnDelete();
            $table->foreignId('skill_id')
                ->constrained('skills')
                ->cascadeOnDelete();
            $table->enum('skill_level', SkillLevel::values())->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_skill', function (Blueprint $table) {
            //
        });
    }
};
