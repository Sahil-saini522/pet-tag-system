<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePetsTable extends Migration
{
public function up()
{
Schema::create('pets', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('name');
$table->string('breed')->nullable();
$table->text('medical')->nullable();
$table->string('photo')->nullable();
$table->string('owner_phone')->nullable();
$table->string('owner_email')->nullable();
$table->string('address')->nullable();
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('pets');
}
}