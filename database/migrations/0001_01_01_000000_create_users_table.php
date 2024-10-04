<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //tabla Rol
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('state');
        });
        //usuario 
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('idrol');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('state');
            $table->foreign('idrol')->references('id')->on('rol')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Insertar roles en la tabla rol
        DB::table('rol')->insert([
            ['name' => 'admin', 'state' => 1],
            ['name' => 'invitado', 'state' => 1],
            ['name' => 'contador', 'state' => 1],
        ]);

        // Insertar un usuario en la tabla users con idrol = 1
        DB::table('users')->insert([
            'name' => 'Admin',
            'idrol' => 1, // Asignar rol "admin"
            'email' => 'xcrissx12345@gmail.com',
            'password' => bcrypt('GEcristianv'), // Asegúrate de usar una contraseña encriptada
            'state' => 1, // Activo por defecto
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
