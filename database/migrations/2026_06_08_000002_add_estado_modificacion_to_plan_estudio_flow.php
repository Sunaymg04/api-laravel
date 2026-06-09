<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plan-estudio', function (Blueprint $table) {
            if (!Schema::hasColumn('plan-estudio', 'estado')) {
                $table->string('estado')->default('esperando_aprobacion')->after('nombre');
            }

            if (!Schema::hasColumn('plan-estudio', 'tipo_plan')) {
                $table->string('tipo_plan')->default('original')->after('estado');
            }

            if (!Schema::hasColumn('plan-estudio', 'plan_origen_id')) {
                $table->unsignedBigInteger('plan_origen_id')->nullable()->after('tipo_plan');
                $table->foreign('plan_origen_id')
                    ->references('id')
                    ->on('plan-estudio')
                    ->nullOnDelete();
            }
        });

        Schema::table('modificacion', function (Blueprint $table) {
            if (!Schema::hasColumn('modificacion', 'plan_origen_id')) {
                $table->unsignedBigInteger('plan_origen_id')->nullable()->after('version_id');
                $table->foreign('plan_origen_id')
                    ->references('id')
                    ->on('plan-estudio')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('modificacion', 'plan_modificado_id')) {
                $table->unsignedBigInteger('plan_modificado_id')->nullable()->after('plan_origen_id');
                $table->foreign('plan_modificado_id')
                    ->references('id')
                    ->on('plan-estudio')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('modificacion', 'estado')) {
                $table->string('estado')->default('esperando_aprobacion')->after('plan_modificado_id');
            }

            if (!Schema::hasColumn('modificacion', 'resumen_cambios')) {
                $table->json('resumen_cambios')->nullable()->after('estado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('modificacion', function (Blueprint $table) {
            foreach (['plan_modificado_id', 'plan_origen_id'] as $column) {
                if (Schema::hasColumn('modificacion', $column)) {
                    $table->dropForeign([$column]);
                }
            }

            foreach (['resumen_cambios', 'estado', 'plan_modificado_id', 'plan_origen_id'] as $column) {
                if (Schema::hasColumn('modificacion', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('plan-estudio', function (Blueprint $table) {
            if (Schema::hasColumn('plan-estudio', 'plan_origen_id')) {
                $table->dropForeign(['plan_origen_id']);
                $table->dropColumn('plan_origen_id');
            }

            foreach (['tipo_plan', 'estado'] as $column) {
                if (Schema::hasColumn('plan-estudio', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
