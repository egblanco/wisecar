<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class AlquilerWizard
{
    private $fechaInicio;

    private $fechaFin;

    private $cliente;

    private $lugarRecogida;

    private $lugarRegreso;

    private $auto;

    private $samePlace;

    private $codigo;

    private $accesorios;

    private $seguros;

    private $total;

    public function __construct()
    {
        $this->accesorios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seguros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setLugarRecogida(\AppBundle\Entity\Lugar $lugarRecogida = null)
    {
        $this->lugarRecogida = $lugarRecogida;

        return $this;
    }

    public function getLugarRecogida()
    {
        return $this->lugarRecogida;
    }

    public function setLugarRegreso(\AppBundle\Entity\Lugar $lugarRegreso = null)
    {
        $this->lugarRegreso = $lugarRegreso;

        return $this;
    }

    public function getLugarRegreso()
    {
        return $this->lugarRegreso;
    }

    public function setAuto(\AppBundle\Entity\Auto $auto = null)
    {
        $this->auto = $auto;

        return $this;
    }

    public function getAuto()
    {
        return $this->auto;
    }

    public function setSamePlace($samePlace)
    {
        $this->samePlace = $samePlace;

        return $this;
    }

    public function getSamePlace()
    {
        return $this->samePlace;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function addAccesorio(\AppBundle\Entity\Accesorio $accesorio)
    {
        $this->accesorios[] = $accesorio;

        return $this;
    }

    public function removeAccesorio(\AppBundle\Entity\Accesorio $accesorio)
    {
        $this->accesorios->removeElement($accesorio);
    }

    public function getAccesorios()
    {
        return $this->accesorios;
    }

    public function addSeguro(\AppBundle\Entity\Seguro $seguro)
    {
        $this->seguros[] = $seguro;

        return $this;
    }

    public function removeSeguro(\AppBundle\Entity\Seguro $seguro)
    {
        $this->seguros->removeElement($seguro);
    }

    public function getSeguros()
    {
        return $this->seguros;
    }

    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

}
