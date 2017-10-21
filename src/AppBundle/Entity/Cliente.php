<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cliente
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
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="sexo", type="object", nullable=true)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="compania", type="string", length=255, nullable=true)
     */
    private $compania;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="correoConfirmacion", type="string", length=255)
     */
    private $correoConfirmacion;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=255, nullable=true)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadPersonas", type="integer")
     */
    private $cantidadPersonas;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enHotel", type="boolean")
     */
    private $enHotel;

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
     * @return Cliente
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
     * Set apellido
     *
     * @param string $apellido
     * @return Cliente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Cliente
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set sexo
     *
     * @param \stdClass $sexo
     * @return Cliente
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return \stdClass 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set compania
     *
     * @param string $compania
     * @return Cliente
     */
    public function setCompania($compania)
    {
        $this->compania = $compania;

        return $this;
    }

    /**
     * Get compania
     *
     * @return string 
     */
    public function getCompania()
    {
        return $this->compania;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
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
     * Set correo
     *
     * @param string $correo
     * @return Cliente
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
     * Set correoConfirmacion
     *
     * @param string $correoConfirmacion
     * @return Cliente
     */
    public function setCorreoConfirmacion($correoConfirmacion)
    {
        $this->correoConfirmacion = $correoConfirmacion;

        return $this;
    }

    /**
     * Get correoConfirmacion
     *
     * @return string 
     */
    public function getCorreoConfirmacion()
    {
        return $this->correoConfirmacion;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Cliente
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Cliente
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Cliente
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Cliente
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Cliente
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set cantidadPersonas
     *
     * @param integer $cantidadPersonas
     * @return Cliente
     */
    public function setCantidadPersonas($cantidadPersonas)
    {
        $this->cantidadPersonas = $cantidadPersonas;

        return $this;
    }

    /**
     * Get cantidadPersonas
     *
     * @return integer 
     */
    public function getCantidadPersonas()
    {
        return $this->cantidadPersonas;
    }

    /**
     * Set enHotel
     *
     * @param boolean $enHotel
     * @return Cliente
     */
    public function setEnHotel($enHotel)
    {
        $this->enHotel = $enHotel;

        return $this;
    }

    /**
     * Get enHotel
     *
     * @return boolean 
     */
    public function getEnHotel()
    {
        return $this->enHotel;
    }
}
