<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Mensaje
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MensajeRepository")
 */
class Mensaje
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
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text")
     */
    private $texto;

    /**
     * @var integer
     *
     * @ORM\Column(name="servicio", type="integer", nullable=true)
     */
    private $servicio;

    /**
     * @ORM\ManyToOne(targetEntity="MensajeTipo", inversedBy="mensajes")
     * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id", nullable=false)
     *
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="MensajeEstado", inversedBy="mensajes")
     * @ORM\JoinColumn(name="id_estado", referencedColumnName="id", nullable=false)
     *
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=255, nullable=true)
     */
    private $locale;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creado;


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
     * @return Mensaje
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
     * Set correo
     *
     * @param string $correo
     * @return Mensaje
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Mensaje
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Mensaje
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Mensaje
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\MensajeTipo $tipo
     * @return Mensaje
     */
    public function setTipo(\AppBundle\Entity\MensajeTipo $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\MensajeTipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return Mensaje
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\MensajeEstado $estado
     * @return Mensaje
     */
    public function setEstado(\AppBundle\Entity\MensajeEstado $estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\MensajeEstado 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Mensaje
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime 
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set servicio
     *
     * @param integer $servicio
     * @return Mensaje
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return integer 
     */
    public function getServicio()
    {
        return $this->servicio;
    }
}
