<?php

namespace AppBundle\Entity;

class AlquilerUpdate
{

    private $correo;

    private $codigo;

    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
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
}
