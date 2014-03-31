<?php

namespace Aml\Bundle\MediasBundle\Entity\Video;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

use Aml\Bundle\MediasBundle\Entity\Video;


/**
 * Aml\Bundle\MediasBundle\Entity\Video\Dailymotion
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\Video\DailymotionRepository")
 */
class Dailymotion extends Video
{

    public function __construct()
    {
        parent::__construct();
        //$this->articles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return 'Dailymotion';
    }


}