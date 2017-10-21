<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlquilerArticulo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AlquilerArticulo
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
     * @ORM\ManyToOne(targetEntity="Alquiler", inversedBy="alquilerArticulos")
     * @ORM\JoinColumn(name="id_alquiler", referencedColumnName="id")
     */
    private $alquiler;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Articulo", inversedBy="alquilerArticulos")
     * @ORM\JoinColumn(name="id_articulo", referencedColumnName="id")
     */
    private $articulo;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", nullable=true)
     */
    protected $precio;

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
     * Set alquiler
     *
     * @param \AppBundle\Entity\Alquiler $alquiler
     * @return AlquilerArticulo
     */
    public function setAlquiler(\AppBundle\Entity\Alquiler $alquiler = null)
    {
        $this->alquiler = $alquiler;

        return $this;
    }

    /**
     * Get alquiler
     *
     * @return \AppBundle\Entity\Alquiler 
     */
    public function getAlquiler()
    {
        return $this->alquiler;
    }

    /**
     * Set articulo
     *
     * @param \AppBundle\Entity\Articulo $articulo
     * @return AlquilerArticulo
     */
    public function setArticulo(\AppBundle\Entity\Articulo $articulo = null)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return \AppBundle\Entity\Articulo 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return AlquilerArticulo
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
}
