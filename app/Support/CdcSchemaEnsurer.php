<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Garantit en production la présence des colonnes/tables attendues par le CDC
 * et les évolutions récentes, sans dépendre de l'historique des migrations Hostinger.
 *
 * Idempotent, sans ->after() (évite les ALTER qui échouent si la colonne "parent" manque).
 */
class CdcSchemaEnsurer
{
    public static function ensure(): void
    {
        static $done = false;
        if ($done) {
            return;
        }
        $done = true;

        try {
            self::ensureBeneficiairesColumns();
            self::ensureVisiteursColumns();
            self::ensureEmployeesColumns();
            self::ensurePointagesStatut();
            self::ensureLot2Tables();
        } catch (\Throwable $e) {
            Log::error('CdcSchemaEnsurer failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
        }
    }

    private static function addStringColumn(string $table, string $column, int $length = 255, bool $nullable = true): void
    {
        if (!Schema::hasTable($table) || Schema::hasColumn($table, $column)) {
            return;
        }

        try {
            Schema::table($table, function (Blueprint $blueprint) use ($column, $length, $nullable) {
                $col = $blueprint->string($column, $length);
                if ($nullable) {
                    $col->nullable();
                }
            });
        } catch (\Throwable $e) {
            Log::warning("CdcSchemaEnsurer: cannot add {$table}.{$column}: " . $e->getMessage());
        }
    }

    private static function addDateColumn(string $table, string $column): void
    {
        if (!Schema::hasTable($table) || Schema::hasColumn($table, $column)) {
            return;
        }

        try {
            Schema::table($table, function (Blueprint $blueprint) use ($column) {
                $blueprint->date($column)->nullable();
            });
        } catch (\Throwable $e) {
            Log::warning("CdcSchemaEnsurer: cannot add {$table}.{$column}: " . $e->getMessage());
        }
    }

    private static function ensureBeneficiairesColumns(): void
    {
        if (!Schema::hasTable('beneficiaires')) {
            return;
        }

        // Colonnes historiques souvent absentes si migrations partielles en prod
        self::addStringColumn('beneficiaires', 'ville');
        self::addStringColumn('beneficiaires', 'reference');
        self::addStringColumn('beneficiaires', 'genre', 20);
        self::addStringColumn('beneficiaires', 'status', 50);
        self::addStringColumn('beneficiaires', 'ass_eps', 50);
        self::addStringColumn('beneficiaires', 'nom_association');
        self::addStringColumn('beneficiaires', 'filiere');
        self::addStringColumn('beneficiaires', 'niveau');
        self::addStringColumn('beneficiaires', 'specialite');
        self::addStringColumn('beneficiaires', 'societe');
        self::addStringColumn('beneficiaires', 'type_intervention', 20);
        self::addStringColumn('beneficiaires', 'niveau_scolarite');
        self::addStringColumn('beneficiaires', 'services_offerts');

        if (!Schema::hasColumn('beneficiaires', 'age')) {
            try {
                Schema::table('beneficiaires', function (Blueprint $blueprint) {
                    $blueprint->unsignedInteger('age')->nullable();
                });
            } catch (\Throwable $e) {
                Log::warning('CdcSchemaEnsurer: cannot add beneficiaires.age: ' . $e->getMessage());
            }
        }

        // CDC Lot 1 / 2
        self::addDateColumn('beneficiaires', 'date_naissance');
        self::addStringColumn('beneficiaires', 'situation_sociale');
        self::addStringColumn('beneficiaires', 'situation_sociale_precision');
        self::addStringColumn('beneficiaires', 'annee_academique', 20);
    }

    private static function ensureVisiteursColumns(): void
    {
        self::addStringColumn('visiteurs', 'genre', 20);
    }

    private static function ensureEmployeesColumns(): void
    {
        self::addStringColumn('employees', 'genre', 20);
    }

    private static function ensurePointagesStatut(): void
    {
        if (!Schema::hasTable('pointages') || !Schema::hasColumn('pointages', 'statut')) {
            return;
        }

        try {
            $column = DB::selectOne("SHOW COLUMNS FROM pointages LIKE 'statut'");
            $type = strtolower((string) ($column->Type ?? ''));
            if ($type !== '' && str_contains($type, 'enum') && !str_contains($type, 'jour_ferie')) {
                DB::statement("ALTER TABLE pointages MODIFY statut ENUM('present','absent','retard','conge','maladie','jour_ferie') NOT NULL DEFAULT 'present'");
            }
        } catch (\Throwable $e) {
            Log::warning('CdcSchemaEnsurer: cannot update pointages.statut enum: ' . $e->getMessage());
        }
    }

    private static function ensureLot2Tables(): void
    {
        if (!Schema::hasTable('beneficiaire_parcours')) {
            try {
                Schema::create('beneficiaire_parcours', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('beneficiaire_id');
                    $table->unsignedBigInteger('ecole_id')->nullable();
                    $table->string('filiere')->nullable();
                    $table->string('niveau')->nullable();
                    $table->string('annee_academique', 20)->nullable();
                    $table->string('statut', 50)->default('Actuel');
                    $table->boolean('is_current')->default(false);
                    $table->text('notes')->nullable();
                    $table->timestamp('started_at')->nullable();
                    $table->timestamp('ended_at')->nullable();
                    $table->unsignedBigInteger('created_by')->nullable();
                    $table->timestamps();
                    $table->index(['beneficiaire_id', 'is_current']);
                });
            } catch (\Throwable $e) {
                Log::warning('CdcSchemaEnsurer: beneficiaire_parcours: ' . $e->getMessage());
            }
        }

        if (!Schema::hasTable('edit_locks')) {
            try {
                Schema::create('edit_locks', function (Blueprint $table) {
                    $table->id();
                    $table->string('lockable_type');
                    $table->unsignedBigInteger('lockable_id');
                    $table->unsignedBigInteger('user_id');
                    $table->string('user_name')->nullable();
                    $table->timestamp('expires_at');
                    $table->timestamps();
                    $table->unique(['lockable_type', 'lockable_id']);
                    $table->index('expires_at');
                });
            } catch (\Throwable $e) {
                Log::warning('CdcSchemaEnsurer: edit_locks: ' . $e->getMessage());
            }
        }

        if (!Schema::hasTable('audit_logs')) {
            try {
                Schema::create('audit_logs', function (Blueprint $table) {
                    $table->id();
                    $table->string('auditable_type');
                    $table->unsignedBigInteger('auditable_id');
                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->string('user_name')->nullable();
                    $table->string('action', 50);
                    $table->json('changes')->nullable();
                    $table->string('ip', 45)->nullable();
                    $table->timestamps();
                    $table->index(['auditable_type', 'auditable_id']);
                });
            } catch (\Throwable $e) {
                Log::warning('CdcSchemaEnsurer: audit_logs: ' . $e->getMessage());
            }
        }

        if (!Schema::hasTable('annees_cloturees')) {
            try {
                Schema::create('annees_cloturees', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedSmallInteger('annee');
                    $table->string('module', 50)->default('beneficiaires');
                    $table->unsignedBigInteger('closed_by')->nullable();
                    $table->string('closed_by_name')->nullable();
                    $table->timestamp('closed_at')->nullable();
                    $table->text('notes')->nullable();
                    $table->timestamps();
                    $table->unique(['annee', 'module']);
                });
            } catch (\Throwable $e) {
                Log::warning('CdcSchemaEnsurer: annees_cloturees: ' . $e->getMessage());
            }
        }
    }
}
