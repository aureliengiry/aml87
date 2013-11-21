<?php

namespace Aml\Bundle\EvenementsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\BlogBundle\Entity\Blog;



/**
 * Aml\Bundle\EvenementsBundle\Entity\EvenementBlog
 *
 * @ORM\Entity
 * @ORM\Table(name="evenements_articles")
 * @ORM\HasLifecycleCallbacks()
 */
class EvenementBlog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="evenementArticle")
     * @ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")
     * */
    protected $evenement;

    /**
     * @ORM\ManyToOne(targetEntity="\Aml\Bundle\BlogBundle\Entity\Blog", inversedBy="evenementArticle")
     * @ORM\JoinColumn(name="id_article", referencedColumnName="id_article")
     * */
    protected $article;

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}