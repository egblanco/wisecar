<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as WiseAssert;

/**
 * Oferta
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_ofertacodigo", columns={"codigo"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OfertaRepository")

 */
class Oferta
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime")
     */
    private $fechaFin;

    /**
     * @ORM\ManyToOne(targetEntity="OfertaTipo", inversedBy="ofertas")
     * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id", nullable=false)
     *
     */
    private $tipo;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="OfertaAuto", mappedBy="oferta", cascade={"all"})
     * @WiseAssert\IsDuplicatedOfertaAuto
     */
    private $ofertaAutos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activa", type="boolean", nullable=true, options={"default" = false})
     */
    private $activa;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=false)
     */
    private $codigo;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Oferta", mappedBy="oferta")
     */
    private $alquileres;

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
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return Oferta
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }


    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\OfertaTipo $tipo
     * @return Oferta
     */
    public function setTipo(\AppBundle\Entity\OfertaTipo $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\OfertaTipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ofertaAutos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alquileres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ofertaAutos
     *
     * @param \AppBundle\Entity\OfertaAuto $ofertaAutos
     * @return Oferta
     */
    public function addOfertaAuto(\AppBundle\Entity\OfertaAuto $ofertaAutos)
    {
        $this->ofertaAutos[] = $ofertaAutos;

        $ofertaAutos->setOferta($this);

        return $this;
    }

    /**
     * Remove ofertaAutos
     *
     * @param \AppBundle\Entity\OfertaAuto $ofertaAutos
     */
    public function removeOfertaAuto(\AppBundle\Entity\OfertaAuto $ofertaAutos)
    {
        $this->ofertaAutos->removeElement($ofertaAutos);
    }

    /**
     * Get ofertaAutos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfertaAutos()
    {
        return $this->ofertaAutos;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     * @return Oferta
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean 
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Oferta
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function getNombreTranslation(){
        if($this->translations['es'] !=  null){
            return $this->translations['es']->getNombre();
        }
        return;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Oferta
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getOfertaAutoByAuto($id){
        foreach($this->getOfertaAutos() as $ofertaAuto){
            if($ofertaAuto->getAuto()->getId() == $id){
                return $ofertaAuto;
            }
        }
        return null;
    }

    public function __toString()
    {
        return $this->getNombre()." (".$this->getCodigo().")";
    }

    /**
     * Add alquileres
     *
     * @param \AppBundle\Entity\Oferta $alquileres
     * @return Oferta
     */
    public function addAlquilere(\AppBundle\Entity\Oferta $alquileres)
    {
        $this->alquileres[] = $alquileres;

        return $this;
    }

    /**
     * Remove alquileres
     *
     * @param \AppBundle\Entity\Oferta $alquileres
     */
    public function removeAlquilere(\AppBundle\Entity\Oferta $alquileres)
    {
        $this->alquileres->removeElement($alquileres);
    }

    /**
     * Get alquileres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlquileres()
    {
        return $this->alquileres;
    }
}
