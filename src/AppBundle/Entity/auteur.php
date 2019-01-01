<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * auteur
 *
 * @ORM\Table(name="auteur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\auteurRepository")
 */
class auteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NomPrenom", type="string", length=20)
     */
    private $nomPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    /**
    * @var int
    *
    * @OneToMany(targetEntity="Livre", mappedBy="auteur")
    */
    private $livre;


    /**
     * Get id
     *
     * @return int
     */
    public function getIdAuteur()
    {
        return $this->id;
    }

    /**
     * Set nomPrenom
     *
     * @param string $nomPrenom
     *
     * @return auteur
     */
    public function setNomPrenom($nomPrenom)
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    /**
     * Get nomPrenom
     *
     * @return string
     */
    public function getNomPrenom()
    {
        return $this->nomPrenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return auteur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
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
     * Constructor
     */
    public function __construct()
    {
        $this->livre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add livre
     *
     * @param \AppBundle\Entity\Livre $livre
     *
     * @return auteur
     */
    public function addLivre(\AppBundle\Entity\Livre $livre)
    {
        $this->livre[] = $livre;

        return $this;
    }

    /**
     * Remove livre
     *
     * @param \AppBundle\Entity\Livre $livre
     */
    public function removeLivre(\AppBundle\Entity\Livre $livre)
    {
        $this->livre->removeElement($livre);
    }

    /**
     * Get livre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLivre()
    {
        return $this->livre;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
