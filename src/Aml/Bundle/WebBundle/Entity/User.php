<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert; // pour la validation
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Symfony\Component\Routing\RequestContext;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Aml\Bundle\WebBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\UserRepository")
 * @UniqueEntity(fields="login", message="Un utilisateur existe déjà avec ce login.")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string $login
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var integer $civilite
     *
     * @ORM\Column(name="civilite", type="integer")
     */
    private $civilite;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string $prenom
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string $adresse
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string $statut
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide",
     *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque",
     *     uploadErrorMessage = "Erreur dans l'upload du fichier"
     * )
     */
    protected $avatar;

    
    // parameters implements UserInterface
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;
    
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set civilite
     *
     * @param integer $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

    /**
     * Get civilite
     *
     * @return integer
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set statut
     *
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    // IMPLEMENT AdvanceUserInterface
    /**
     * Renvoi si le compte est actif
     */
    public function isEnabled()
    {
        return $this->statut;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Renvoi si le compte est non-expiré
     */
    public function isAccountNonExpired()
    {
        return true;
    }
    
    // ##################### implement UserInterface #####################
    
    /**
     * Récupère tous les rôles symfony de l'utilisateur en fonction de ses communautés
     */
    public function getRoles()
    {    	
    	$roles = array('ROLE_ADMIN');
    
    	return $roles;
    }
    
    /**
     * Set the value of salt.
     *
     * @param string $salt
     * @return \Ic\Bundle\PslwebBundle\Entity\User
     */
    public function setSalt($salt)
    {
    	$this->salt = $salt;
    
    	return $this;
    }
    
    /**
     * Get the value of salt.
     *
     * @return string
     */
    public function getSalt()
    {
    	return $this->salt;
    }
    
    /**
     * Retourne l'username
     */
    public function getUsername()
    {
    	return $this->login;
    }
    
    public function eraseCredentials()
    {
    	$this->Password = null;
    }
    
    function equals(UserInterface $user){
    	return true;
    }
    
	/**
	 * Encode le mot de passe
	 * @param PasswordEncoderInterface $encoder
	 */
    public function encodePassword(PasswordEncoderInterface $encoder)
    {
        if($this->password)
	{
            $this->salt = sha1(uniqid().time().rand(0,999999));
            $this->password = $encoder->encodePassword
            (
                $this->password,
                $this->salt
            );
        }
    }
}