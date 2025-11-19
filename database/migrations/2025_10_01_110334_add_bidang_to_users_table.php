<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // add bidang and jabatan to users so we can consolidate pegawai data into users
            if (!Schema::hasColumn('users', 'bidang')) {
                $table->string('bidang', 100)->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan', 255)->nullable()->after('bidang');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
            if (Schema::hasColumn('users', 'bidang')) {
                $table->dropColumn('bidang');
            }
        });
    }
};
