<?php
namespace Aml\Bundle\UrlRewriteBundle\Utils;

class Slugger
{
    protected $outputString = '';

    /**
     * Remove letter with accent
     *
     * @see http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     *
     * @param $string
     */
    protected function removeAccent()
    {
        $this->outputString = str_replace(
            array(
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
                'Ý'
            ),
            array(
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
                'Y'
            ),
            $this->outputString
        );
    }

    /**
     * Clean string (remove accents, special characters) for URL or filename
     *
     * @param string $str
     * @param string $replace
     * @param bool $lowercase
     *
     * @return mixed|string
     */
    public function slugify($str, $replace = '-', $lowercase = true)
    {
        $this->outputString = $str;

        $this->removeAccent();

        $trans = array(
            '&\#\d+?;' => '',
            '&\S+?;' => '',
            '\s+' => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace . '+' => $replace,
            $replace . '$' => $replace,
            '^' . $replace => $replace,
            '\.+$' => ''
        );

        $this->outputString = strip_tags($this->outputString);

        foreach ($trans as $key => $val) {
            $this->outputString = preg_replace("#" . $key . "#i", $val, $this->outputString);
        }

        if ($lowercase === true) {
            $this->outputString = strtolower($this->outputString);
        }

        $this->outputString = trim(stripslashes($this->outputString));
        $this->outputString = str_replace(array('.'), array('-'), $this->outputString);

        // Check and clean last character
        $lastCharacter = substr($this->outputString, -1);
        if ($lastCharacter == '-') {
            $this->outputString = substr($this->outputString, 0, -1);
        }

        return $this->outputString;
    }
}
