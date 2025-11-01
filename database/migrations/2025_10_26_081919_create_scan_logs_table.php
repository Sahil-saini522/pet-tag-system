<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateScanLogsTable extends Migration
{
public function up()
{
Schema::create('scan_logs', function (Blueprint $table) {
$table->id();
$table->foreignId('tag_id')->constrained()->onDelete('cascade');
$table->string('ip')->nullable();
$table->string('user_agent')->nullable();
$table->timestamp('scanned_at')->useCurrent();
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('scan_logs');
}
}
