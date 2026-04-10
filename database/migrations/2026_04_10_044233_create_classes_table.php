<?php
// database/migrations/2024_01_01_000002_create_classes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_code', 50)->unique();
            $table->string('class_name');
            $table->string('teacher_name');
            $table->integer('max_students')->default(30);
            $table->text('description')->nullable();
            $table->string('room')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};