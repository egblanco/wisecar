<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Accesorio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AccesorioRepository")
 * @Vich\Uploadable
 *
 */
class Accesorio extends Articulo
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    protected $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="disponible", type="integer")
     */
    protected $disponible;

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

    protected $translations;

    public function __contruct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getNombreTranslation(){
        if($this->translations['es'] !=  null){
            return $this->translations['es']->getNombre();
        }
        return;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Accesorio
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set disponible
     *
     * @param integer $disponible
     * @return Accesorio
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return integer 
     */
    public function getDisponible()
    {
        return $this->disponible;
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
        return $this->getNombre();
    }
}
