<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MensajeTipo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TextoTipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
    * @ORM\OneToMany(targetEntity="Texto", mappedBy="tipo")
    **/
    private $textos;


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
     * Set nombre
     *
     * @param string $nombre
     * @return MensajeTipo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->textos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Add textos
     *
     * @param \AppBundle\Entity\Texto $textos
     * @return TextoTipo
     */
    public function addTexto(\AppBundle\Entity\Texto $textos)
    {
        $this->textos[] = $textos;

        return $this;
    }

    /**
     * Remove textos
     *
     * @param \AppBundle\Entity\Texto $textos
     */
    public function removeTexto(\AppBundle\Entity\Texto $textos)
    {
        $this->textos->removeElement($textos);
    }

    /**
     * Get textos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTextos()
    {
        return $this->textos;
    }
}
