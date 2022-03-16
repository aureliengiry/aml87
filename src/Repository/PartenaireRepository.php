<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Repository;

use App\Entity\Partenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partenaire>
 *
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findAll()
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenaire::class);
    }

    /**
     * Function to delete tumblr/tags relation.
     */
    public function cleanTags(Partenaire $partenaire): void
    {
        $em = $this->getEntityManager();
        foreach ($partenaire->getTags() as $tag) {
            $partenaire->removeTag($tag);
        }
        $em->flush();
    }

    /**
     * Function to delete tumblr/tags relation.
     */
    public function cleanLogo(Partenaire $partenaire): void
    {
        $em = $this->getEntityManager();
        foreach ($partenaire->getLogo() as $tag) {
            $partenaire->removeTag($tag);
        }
        $em->flush();
    }
}
