<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('remember_token')->nullable();
            $table->enum('role', ['customer', 'vendor', 'affiliate', 'admin']);
            $table->enum('status', ['active', 'inactive']);
            $table->decimal('current_balance', 8, 2)->default(0);
            $table->decimal('earning_balance', 8, 2)->default(0);
            $table->decimal('withdrawal_balance', 8, 2)->default(0);
            $table->decimal('deposit_balance', 8, 2)->default(0);
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('referral_code')->default(Str::random(10))->unique();
            $table->string('referrer_id')->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};