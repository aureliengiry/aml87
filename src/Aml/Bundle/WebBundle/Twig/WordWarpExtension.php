<?php
namespace Aml\Bundle\WebBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class WordWarpExtension extends Twig_Extension
{
	public function getFilters()
	{
		return array
		(
				'wordWarp' => new Twig_Filter_Method($this, 'wordWarpFilter', array('is_safe' => array('html'))),
				'isWordWarp' => new Twig_Filter_Method($this, 'isWordWarpFilter')
		);
	}
	
	/**
	 * réduit une chaine de caractères sans couper les mots
	 *
	 * @param string $date date à transformer
	 * @param boolean $dateonly Affiche la date uniquement, quoiqu'il arrive
	 * @param boolean $icon afficher ou non l'icône avant la date
	 * @param string $format format dans lequel retourner la date si pas transformée
	 * 
	 * @return string date plus nice à lire
	 */
	function wordWarpFilter($str, $length = 200, $id = null, $wordwarp = true)
	{
		$str = $this->stripHtmlTags($str);
		if(strlen($str) > $length)
		{
			if($wordwarp) $length = $this->findSpace($str, $length);
			if(is_null($id)) $id = '';
			else $id = ' id="wordWarp-'.$id.'"';
			$text = '<div class="expand"'.$id.'>'.mb_substr($str, 0, $length).' <div class="emphasis">[...]</div> <div class="read-more">';
			$text .= mb_substr($str, $length, strlen($str)).'</div></div>';
			return $text;
		}
		return $str;
	}

	/**
	 * réduit une chaine de caractères sans couper les mots
	 *
	 * @param string $date date à transformer
	 * @param boolean $dateonly Affiche la date uniquement, quoiqu'il arrive
	 * @param boolean $icon afficher ou non l'icône avant la date
	 * @param string $format format dans lequel retourner la date si pas transformée
	 * 
	 * @return string date plus nice à lire
	 */
	function isWordWarpFilter($str, $length = 200)
	{
		$str = $this->stripHtmlTags($str);
		if(strlen($str) > $length)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Remove HTML tags, including invisible text such as style and
	 * script code, and embedded objects.  Add line breaks around
	 * block-level tags to prevent word joining after tag removal.
	 */
	function stripHtmlTags( $text )
	{
		$allowedTags = '<strong><em>';
		return strip_tags( $text, $allowedTags );
	}	

	public function getName()
	{
		return 'wordWarp_extension';
	}
	
	public function findSpace($str, $length)
	{
		while($length > 0 && !$val = mb_strpos($str, ' ', $length))
		{
			$length = $length - 10;
		}
		return $val;
	}
}