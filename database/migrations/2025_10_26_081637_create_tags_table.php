<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateTagsTable extends Migration
{
public function up()
{
Schema::create('tags', function (Blueprint $table) {
$table->id();
$table->string('tag_code')->unique(); // e.g. TAG12345
$table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
$table->foreignId('pet_id')->nullable()->constrained()->onDelete('set null');
$table->boolean('active')->default(false);
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('tags');
}
}