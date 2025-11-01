<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateMembershipsTable extends Migration
{
public function up()
{
Schema::create('memberships', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->date('starts_at');
$table->date('expires_at');
$table->string('stripe_payment_id')->nullable();
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('memberships');
}
}
