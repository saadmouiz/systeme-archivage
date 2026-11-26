<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Ajoute de façon idempotente les colonnes/tables CDC manquantes.
 * Utile en production quand php artisan migrate n'a pas encore été lancé.
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

        if (Schema::hasTable('beneficiaires')) {
            Schema::table('beneficiaires', function (Blueprint $table) {
                if (!Schema::hasColumn('beneficiaires', 'nom_association')) {
                    $table->string('nom_association')->nullable()->after('ass_eps');
                }
                if (!Schema::hasColumn('beneficiaires', 'date_naissance')) {
                    $table->date('date_naissance')->nullable()->after('age');
                }
                if (!Schema::hasColumn('beneficiaires', 'situation_sociale')) {
                    $table->string('situation_sociale')->nullable()->after('genre');
                }
                if (!Schema::hasColumn('beneficiaires', 'situation_sociale_precision')) {
                    $table->string('situation_sociale_precision')->nullable()->after('situation_sociale');
                }
                if (!Schema::hasColumn('beneficiaires', 'annee_academique')) {
                    $table->string('annee_academique', 20)->nullable()->after('filiere');
                }
            });
        }

        if (Schema::hasTable('visiteurs') && !Schema::hasColumn('visiteurs', 'genre')) {
            Schema::table('visiteurs', function (Blueprint $table) {
                $table->string('genre')->nullable()->after('cin');
            });
        }

        if (Schema::hasTable('employees') && !Schema::hasColumn('employees', 'genre')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('genre')->nullable()->after('prenom');
            });
        }

        if (!Schema::hasTable('beneficiaire_parcours')) {
            Schema::create('beneficiaire_parcours', function (Blueprint $table) {
                $table->id();
                $table->foreignId('beneficiaire_id')->constrained('beneficiaires')->cascadeOnDelete();
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
        }

        if (!Schema::hasTable('edit_locks')) {
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
        }

        if (!Schema::hasTable('audit_logs')) {
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
        }

        if (!Schema::hasTable('annees_cloturees')) {
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
        }
    }
}
