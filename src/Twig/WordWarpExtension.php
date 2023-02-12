<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class WordWarpExtension.
 */
class WordWarpExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('wordWarp', $this->wordWarpFilter(...), ['is_safe' => ['html']]),
            new TwigFilter('isWordWarp', $this->isWordWarpFilter(...)),
        ];
    }

    /**
     * Réduit une chaine de caractères sans couper les mots.
     */
    public function wordWarpFilter(string $str, ?int $length = 500, bool $wordwarp = true): string
    {
        // Delete HTML tags
        $str = $this->stripHtmlTags($str);

        // Delete \n \r \t
        $str = str_replace(["\r\n", "\n", "\r", "\t"], '', $str);

        if (mb_strlen($str) > $length) {
            if ($wordwarp) {
                $length = $this->findSpace($str, $length);
            }

            return '<div class="expand">'.mb_substr($str, 0, $length).' ...</div>';
        }

        return $str;
    }

    /**
     * Réduit une chaine de caractères sans couper les mots.
     */
    public function isWordWarpFilter(string $str, ?int $length = 200): bool
    {
        $str = $this->stripHtmlTags($str);

        return mb_strlen($str) > $length;
    }

    /**
     * Remove HTML tags, including invisible text such as style and
     * script code, and embedded objects.  Add line breaks around
     * block-level tags to prevent word joining after tag removal.
     */
    public function stripHtmlTags(string $text): string
    {
        $allowedTags = '<strong><em>';

        return strip_tags($text, $allowedTags);
    }

    public function findSpace(string $str, int $length)
    {
        $val = null;
        while ($length > 0 && ! $val = mb_strpos($str, ' ', $length)) {
            $length -= 10;
        }

        return $val;
    }
}
