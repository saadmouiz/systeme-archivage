<?php

namespace App\Support;

use ArPHP\I18N\Arabic;

/**
 * Prépare le texte (arabe inclus) pour DomPDF.
 * DomPDF n'applique pas le shaping RTL : on convertit les glyphes arabes.
 */
class ArabicPdfText
{
    private static ?Arabic $engine = null;

    public static function format(?string $text): string
    {
        $text = (string) ($text ?? '');
        if ($text === '') {
            return '';
        }

        // Pas d'arabe → rien à transformer
        if (!preg_match('/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}]/u', $text)) {
            return $text;
        }

        try {
            if (!self::$engine) {
                self::$engine = new Arabic();
            }

            return self::$engine->utf8Glyphs($text);
        } catch (\Throwable $e) {
            return $text;
        }
    }
}
