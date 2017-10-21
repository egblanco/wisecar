<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MensajeTipo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MensajeTipo
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
    * @ORM\OneToMany(targetEntity="Mensaje", mappedBy="tipo")
    **/
    private $mensajes;


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
        $this->mensajes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mensajes
     *
     * @param \AppBundle\Entity\Mensaje $mensajes
     * @return MensajeTipo
     */
    public function addMensaje(\AppBundle\Entity\Mensaje $mensajes)
    {
        $this->mensajes[] = $mensajes;

        return $this;
    }

    /**
     * Remove mensajes
     *
     * @param \AppBundle\Entity\Mensaje $mensajes
     */
    public function removeMensaje(\AppBundle\Entity\Mensaje $mensajes)
    {
        $this->mensajes->removeElement($mensajes);
    }

    /**
     * Get mensajes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
