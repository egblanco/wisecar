<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Auto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AutoRepository")
 * @Vich\Uploadable
 */
class Auto extends Articulo
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
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    protected $modelo;

    /**
     * @var integer
     *
     * @ORM\Column(name="pasajeros", type="integer")
     */
    protected $pasajeros;

    /**
     * @var integer
     *
     * @ORM\Column(name="puertas", type="integer")
     */
    protected $puertas;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aire", type="boolean")
     */
    protected $aire;

    /**
     * @var integer
     *
     * @ORM\Column(name="maletas_grandes", type="integer")
     */
    protected $maletasGrandes;

    /**
     * @var integer
     *
     * @ORM\Column(name="maletas_pequenas", type="integer")
     */
    protected $maletasPequenas;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cd_reproductor", type="boolean")
     */
    protected $cdReproductor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usb", type="boolean")
     */
    protected $usb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="auxiliar", type="boolean")
     */
    protected $auxiliar;

    /**
     * @var integer
     *
     * @ORM\Column(name="pad", type="integer")
     */
    protected $pad;

    /**
     * @var integer
     *
     * @ORM\Column(name="pas", type="integer")
     */
    protected $pas;

    /**
     * @ORM\ManyToOne(targetEntity="Transmision", inversedBy="autos")
     * @ORM\JoinColumn(name="id_transmision", referencedColumnName="id", nullable=false)
     *
     */
    protected $transmision;

    /**
     * @ORM\ManyToOne(targetEntity="AutoCategoria", inversedBy="autos")
     * @ORM\JoinColumn(name="id_categoria", referencedColumnName="id", nullable=false)
     *
     */
    protected $categoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    protected $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @Assert\File(
     *      maxSize="1M",
     *      mimeTypes={"image/png", "image/jpeg", "image/gif"}
     * )
     * @var File
     */
    protected $imageFile;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="OfertaAuto", mappedBy="auto", cascade={"all"})
     */
    private $ofertaAutos;

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
     * Set pasajeros
     *
     * @param integer $pasajeros
     * @return Auto
     */
    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;

        return $this;
    }

    /**
     * Get pasajeros
     *
     * @return integer 
     */
    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    /**
     * Set puertas
     *
     * @param integer $puertas
     * @return Auto
     */
    public function setPuertas($puertas)
    {
        $this->puertas = $puertas;

        return $this;
    }

    /**
     * Get puertas
     *
     * @return integer 
     */
    public function getPuertas()
    {
        return $this->puertas;
    }

    /**
     * Set aire
     *
     * @param boolean $aire
     * @return Auto
     */
    public function setAire($aire)
    {
        $this->aire = $aire;

        return $this;
    }

    /**
     * Get aire
     *
     * @return boolean 
     */
    public function getAire()
    {
        return $this->aire;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Auto
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set usb
     *
     * @param boolean $usb
     * @return Auto
     */
    public function setUsb($usb)
    {
        $this->usb = $usb;

        return $this;
    }

    /**
     * Get usb
     *
     * @return boolean 
     */
    public function getUsb()
    {
        return $this->usb;
    }

    /**
     * Set auxiliar
     *
     * @param boolean $auxiliar
     * @return Auto
     */
    public function setAuxiliar($auxiliar)
    {
        $this->auxiliar = $auxiliar;

        return $this;
    }

    /**
     * Get auxiliar
     *
     * @return boolean 
     */
    public function getAuxiliar()
    {
        return $this->auxiliar;
    }

    /**
     * Set pad
     *
     * @param integer $pad
     * @return Auto
     */
    public function setPad($pad)
    {
        $this->pad = $pad;

        return $this;
    }

    /**
     * Get pad
     *
     * @return integer 
     */
    public function getPad()
    {
        return $this->pad;
    }

    /**
     * Set pas
     *
     * @param integer $pas
     * @return Auto
     */
    public function setPas($pas)
    {
        $this->pas = $pas;

        return $this;
    }

    /**
     * Get pas
     *
     * @return integer 
     */
    public function getPas()
    {
        return $this->pas;
    }

    /**
     * Set transmision
     *
     * @param \AppBundle\Entity\Transmision $transmision
     * @return Auto
     */
    public function setTransmision(\AppBundle\Entity\Transmision $transmision)
    {
        $this->transmision = $transmision;

        return $this;
    }

    /**
     * Get transmision
     *
     * @return \AppBundle\Entity\Transmision 
     */
    public function getTransmision()
    {
        return $this->transmision;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\AutoCategoria $categoria
     * @return Auto
     */
    public function setCategoria(\AppBundle\Entity\AutoCategoria $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\AutoCategoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set maletasGrandes
     *
     * @param integer $maletasGrandes
     * @return Auto
     */
    public function setMaletasGrandes($maletasGrandes)
    {
        $this->maletasGrandes = $maletasGrandes;

        return $this;
    }

    /**
     * Get maletasGrandes
     *
     * @return integer 
     */
    public function getMaletasGrandes()
    {
        return $this->maletasGrandes;
    }

    /**
     * Set maletasPequenas
     *
     * @param integer $maletasPequenas
     * @return Auto
     */
    public function setMaletasPequenas($maletasPequenas)
    {
        $this->maletasPequenas = $maletasPequenas;

        return $this;
    }

    /**
     * Get maletasPequenas
     *
     * @return integer 
     */
    public function getMaletasPequenas()
    {
        return $this->maletasPequenas;
    }

    /**
     * Set cdReproductor
     *
     * @param boolean $cdReproductor
     * @return Auto
     */
    public function setCdReproductor($cdReproductor)
    {
        $this->cdReproductor = $cdReproductor;

        return $this;
    }

    /**
     * Get cdReproductor
     *
     * @return boolean 
     */
    public function getCdReproductor()
    {
        return $this->cdReproductor;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->getModelo();
    }

    /**
     * Add ofertaAutos
     *
     * @param \AppBundle\Entity\OfertaAuto $ofertaAutos
     * @return Auto
     */
    public function addOfertaAuto(\AppBundle\Entity\OfertaAuto $ofertaAutos)
    {
        $this->ofertaAutos[] = $ofertaAutos;

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
}
