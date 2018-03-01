<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Url;

/**
 * Class UrlEvenement
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 */
class UrlEvenement extends Url
{

}
