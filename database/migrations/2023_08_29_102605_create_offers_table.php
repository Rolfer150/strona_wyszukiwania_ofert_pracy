<?php

use App\Enums\Contract;
use App\Enums\Employment;
use App\Enums\PaymentType;
use App\Enums\WorkMode;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('slug', 128);
            $table->string('image_path', 2048)->nullable();
            $table->longText('description')->nullable();
            $table->json('tasks')->nullable();
            $table->json('expectancies')->nullable();
            $table->json('additionals')->nullable();
            $table->json('assurances')->nullable();
            $table->float('salary')->nullable();
            $table->enum('payment', PaymentType::values())
                ->default(PaymentType::MBRUTTO->value);
            $table->integer('vacancy')->default(1);
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->enum('employment', Employment::values());
            $table->enum('contract', Contract::values());
            $table->enum('work_mode', WorkMode::values());
            $table->boolean('active');
            $table->foreignIdFor(User::class, 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
