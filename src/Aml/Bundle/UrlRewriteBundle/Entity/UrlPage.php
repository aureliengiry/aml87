<?php
namespace Aml\Bundle\UrlRewriteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Aml\Bundle\UrlRewriteBundle\Entity\Url;

/**
 * Class UrlArticle
 * @package Aml\Bundle\UrlRewriteBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\UrlRewriteBundle\Entity\Repository\UrlRepository")
 */
class UrlPage extends Url
{

}