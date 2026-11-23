<?php

namespace App\Support;

use App\Models\AnneeCloturee;

class PeriodLock
{
    public static function assertOpen(int $annee, string $module = 'beneficiaires'): void
    {
        if (AnneeCloturee::isClosed($annee, $module)) {
            abort(403, "L'exercice {$annee} est clôturé : aucune modification n'est autorisée.");
        }
    }

    public static function yearFromReference(?string $reference): ?int
    {
        if (!$reference) {
            return null;
        }
        if (preg_match('/[\/\-]((?:19|20)\d{2})\b/', $reference, $m)) {
            return (int) $m[1];
        }
        if (preg_match('/\b((?:19|20)\d{2})\b/', $reference, $m)) {
            return (int) $m[1];
        }
        return null;
    }

    public static function yearFromAcademique(?string $anneeAcademique): ?int
    {
        if (!$anneeAcademique) {
            return null;
        }
        // "2026/2027" → use first year, or last 4 digits
        if (preg_match('/((?:19|20)\d{2})/', $anneeAcademique, $m)) {
            return (int) $m[1];
        }
        return null;
    }
}
