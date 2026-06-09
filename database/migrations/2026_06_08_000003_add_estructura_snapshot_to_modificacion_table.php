<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modificacion', function (Blueprint $table) {
            if (!Schema::hasColumn('modificacion', 'estructura_snapshot')) {
                $table->json('estructura_snapshot')->nullable()->after('resumen_cambios');
            }
        });
    }

    public function down(): void
    {
        Schema::table('modificacion', function (Blueprint $table) {
            if (Schema::hasColumn('modificacion', 'estructura_snapshot')) {
                $table->dropColumn('estructura_snapshot');
            }
        });
    }
};
