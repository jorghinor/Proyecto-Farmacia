<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up() {
    Schema::create('medicamentos', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->decimal('precio',10,2);
      $table->integer('stock');
      $table->date('fecha_vencimiento');
      $table->timestamps();
    });
  }
  public function down() {
    Schema::dropIfExists('medicamentos');
  }
};
