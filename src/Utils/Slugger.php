<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Utils;

/**
 * Class Slugger.
 */
class Slugger
{
    protected $outputString = '';

    /**
     * Remove letter with accent.
     *
     * @see http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     *
     * @param $string
     */
    protected function removeAccent()
    {
        $this->outputString = str_replace(
            [
                'à',
                'á',
                'â',
                'ã',
                'ä',
                'ç',
                'è',
                'é',
                'ê',
                'ë',
                'ì',
                'í',
                'î',
                'ï',
                'ñ',
                'ò',
                'ó',
                'ô',
                'õ',
                'ö',
                'ù',
                'ú',
                'û',
                'ü',
                'ý',
                'ÿ',
                'À',
                'Á',
                'Â',
                'Ã',
                'Ä',
                'Ç',
                'È',
                'É',
                'Ê',
                'Ë',
                'Ì',
                'Í',
                'Î',
                'Ï',
                'Ñ',
                'Ò',
                'Ó',
                'Ô',
                'Õ',
                'Ö',
                'Ù',
                'Ú',
                'Û',
                'Ü',
                'Ý',
            ],
            [
                'a',
                'a',
                'a',
                'a',
                'a',
                'c',
                'e',
                'e',
                'e',
                'e',
                'i',
                'i',
                'i',
                'i',
                'n',
                'o',
                'o',
                'o',
                'o',
                'o',
                'u',
                'u',
                'u',
                'u',
                'y',
                'y',
                'A',
                'A',
                'A',
                'A',
                'A',
                'C',
                'E',
                'E',
                'E',
                'E',
                'I',
                'I',
                'I',
                'I',
                'N',
                'O',
                'O',
                'O',
                'O',
                'O',
                'U',
                'U',
                'U',
                'U',
                'Y',
            ],
            $this->outputString
        );
    }

    /**
     * Clean string (remove accents, special characters) for URL or filename.
     *
     *
     * @return mixed|string
     */
    public function slugify(string $str, string $replace = '-', bool $lowercase = true)
    {
        $this->outputString = $str;

        $this->removeAccent();

        $trans = [
            '&\#\d+?;' => '',
            '&\S+?;' => '',
            '\s+' => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace.'+' => $replace,
            $replace.'$' => $replace,
            '^'.$replace => $replace,
            '\.+$' => '',
        ];

        $this->outputString = strip_tags($this->outputString);

        foreach ($trans as $key => $val) {
            $this->outputString = preg_replace('#'.$key.'#i', $val, $this->outputString);
        }

        if (true === $lowercase) {
            $this->outputString = mb_strtolower($this->outputString);
        }

        $this->outputString = trim(stripslashes($this->outputString));
        $this->outputString = str_replace(['.'], ['-'], $this->outputString);

        // Check and clean last character
        $lastCharacter = mb_substr($this->outputString, -1);
        if ('-' === $lastCharacter) {
            $this->outputString = mb_substr($this->outputString, 0, -1);
        }

        return $this->outputString;
    }
}
