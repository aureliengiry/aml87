<?php
namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Aml\Bundle\WebBundle\Entity\Url;

/**
 * Class UrlArticle
 * @package Aml\Bundle\WebBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Repository\UrlRepository")
 */
class UrlPage extends Url
{

}
