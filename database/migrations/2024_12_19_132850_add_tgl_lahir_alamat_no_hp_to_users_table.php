<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglLahirAlamatNoHpToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('tgl_lahir')->nullable()->after('email'); // Kolom tanggal lahir
            $table->text('alamat')->nullable()->after('tgl_lahir'); // Kolom alamat
            $table->string('no_hp', 15)->nullable()->after('alamat'); // Kolom nomor HP
            $table->string('role')->default('user')->after('no_hp'); // Kolom role dengan nilai default 'user'
            $table->date('tgl_keluar')->nullable()->after('role');  // Kolom tanggal keluar
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tgl_lahir', 'alamat', 'no_hp','role', 'tgl_keluar']); // Hapus kolom jika migrasi di-rollback
        });
    }
}
