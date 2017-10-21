<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArticuloRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"articulo" = "Articulo", "accesorio" = "Accesorio", "auto" = "Auto", "seguro" = "Seguro"})
 *
 */
class Articulo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal")
     */
    protected $precio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="AlquilerArticulo", mappedBy="articulo", cascade={"all"})
     */
    private $alquilerArticulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alquilerArticulos = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set precio
     *
     * @param string $precio
     * @return Articulo
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

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Articulo
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add alquilerArticulos
     *
     * @param \AppBundle\Entity\AlquilerArticulo $alquilerArticulos
     * @return Articulo
     */
    public function addAlquilerArticulo(\AppBundle\Entity\AlquilerArticulo $alquilerArticulos)
    {
        $this->alquilerArticulos[] = $alquilerArticulos;

        return $this;
    }

    /**
     * Remove alquilerArticulos
     *
     * @param \AppBundle\Entity\AlquilerArticulo $alquilerArticulos
     */
    public function removeAlquilerArticulo(\AppBundle\Entity\AlquilerArticulo $alquilerArticulos)
    {
        $this->alquilerArticulos->removeElement($alquilerArticulos);
    }

    /**
     * Get alquilerArticulos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlquilerArticulos()
    {
        return $this->alquilerArticulos;
    }

    public function getObject()
    {
        return $this;
    }
}
