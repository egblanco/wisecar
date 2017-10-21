<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaAuto
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_ofertaauto", columns={"id_oferta", "id_auto"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OfertaAutoRepository")
 */
class OfertaAuto
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Oferta", inversedBy="ofertaAutos")
     * @ORM\JoinColumn(name="id_oferta", referencedColumnName="id", nullable=false)
     */
    private $oferta;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Auto", inversedBy="ofertaAutos")
     * @ORM\JoinColumn(name="id_auto", referencedColumnName="id", nullable=false)
     */
    private $auto;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal")
     */
    protected $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="semanal", type="decimal")
     */
    protected $semanal;


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
     * Set oferta
     *
     * @param \AppBundle\Entity\Oferta $oferta
     * @return OfertaAuto
     */
    public function setOferta(\AppBundle\Entity\Oferta $oferta = null)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Get oferta
     *
     * @return \AppBundle\Entity\Oferta 
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Set auto
     *
     * @param \AppBundle\Entity\Auto $auto
     * @return OfertaAuto
     */
    public function setAuto(\AppBundle\Entity\Auto $auto = null)
    {
        $this->auto = $auto;

        return $this;
    }

    /**
     * Get auto
     *
     * @return \AppBundle\Entity\Auto 
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return OfertaAuto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    public function getObject()
    {
        return $this;
    }

    public function __toString()
    {
        return $this->auto->getModelo();
    }

    /**
     * Set semanal
     *
     * @param string $semanal
     * @return OfertaAuto
     */
    public function setSemanal($semanal)
    {
        $this->semanal = $semanal;

        return $this;
    }

    /**
     * Get semanal
     *
     * @return string 
     */
    public function getSemanal()
    {
        return $this->semanal;
    }
}
