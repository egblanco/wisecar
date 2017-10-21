<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaTipo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OfertaTipo
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
     * @var string
     *
     * @ORM\Column(name="prioridad", type="integer")
     */
    protected $prioridad;

    /**
     * @ORM\OneToMany(targetEntity="Oferta", mappedBy="tipo")
     **/
    private $ofertas;


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
     * @return OfertaTipo
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
        $this->ofertas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ofertas
     *
     * @param \AppBundle\Entity\Oferta $ofertas
     * @return OfertaTipo
     */
    public function addOferta(\AppBundle\Entity\Oferta $ofertas)
    {
        $this->ofertas[] = $ofertas;

        return $this;
    }

    /**
     * Remove ofertas
     *
     * @param \AppBundle\Entity\Oferta $ofertas
     */
    public function removeOferta(\AppBundle\Entity\Oferta $ofertas)
    {
        $this->ofertas->removeElement($ofertas);
    }

    /**
     * Get ofertas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfertas()
    {
        return $this->ofertas;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Set prioridad
     *
     * @param integer $prioridad
     * @return OfertaTipo
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return integer 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }
}
