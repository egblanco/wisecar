<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transmision
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Transmision
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Auto", mappedBy="transmision")
     **/
    private $autos;

    private $translations;


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
     * Constructor
     */
    public function __construct()
    {
        $this->autos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add autos
     *
     * @param \AppBundle\Entity\Auto $autos
     * @return Transmision
     */
    public function addAuto(\AppBundle\Entity\Auto $autos)
    {
        $this->autos[] = $autos;

        return $this;
    }

    /**
     * Remove autos
     *
     * @param \AppBundle\Entity\Auto $autos
     */
    public function removeAuto(\AppBundle\Entity\Auto $autos)
    {
        $this->autos->removeElement($autos);
    }

    /**
     * Get autos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAutos()
    {
        return $this->autos;
    }

    public function getNombre(){
        return $this->translations['es']->getNombre();
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
