<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PartenaireRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartenaireRepository extends EntityRepository
{
    /**
     * Function to delete tumblr/tags relation.
     *
     * @param MongoboxTumblrBundle :Tumblr $partenaire
     */
    public function cleanTags($partenaire)
    {
        $em = $this->getEntityManager();
        foreach ($partenaire->getTags() as $tag) {
            $partenaire->removeTag($tag);
        }
        $em->flush();
    }

    /**
     * Function to delete tumblr/tags relation.
     *
     * @param MongoboxTumblrBundle :Tumblr $partenaire
     */
    public function cleanLogo($partenaire)
    {
        $em = $this->getEntityManager();
        foreach ($partenaire->getLogo() as $tag) {
            $partenaire->removeTag($tag);
        }
        $em->flush();
    }
}
