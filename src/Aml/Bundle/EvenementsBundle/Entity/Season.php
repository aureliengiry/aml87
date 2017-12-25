<?php
namespace Aml\Bundle\EvenementsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aml\Bundle\EvenementsBundle\Entity\Season
 *
 * @ORM\Table(name="evenements_seasons")
 * @ORM\Entity(repositoryClass="Aml\Bundle\EvenementsBundle\Repository\SeasonRepository")
 */
class Season
{
    const SEASON_DEFAULT_DATE_START = '%s-09-01';
    const SEASON_DEFAULT_DATE_END = '%s-08-31';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_season", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var datetime $dateStart
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var datetime $dateEnd
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="season")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_evenement")
     */
    protected $evenements;

    /**
     * @return datetime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param datetime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return datetime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param datetime $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /* ----------- EVENEMENTS ------------ */
    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

    /**
     *
     * @param Evenement $evenement
     */
    public function addEvenement($evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name ? $this->name : 'New Season';
    }

    public function createStartDate($year){

        $str = sprintf(self::SEASON_DEFAULT_DATE_START,$year);
        return new \DateTime($str);
    }
}
