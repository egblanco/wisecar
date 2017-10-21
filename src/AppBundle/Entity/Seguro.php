<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Seguro
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SeguroRepository")
 * @Vich\Uploadable
 */
class Seguro extends Articulo
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

    public function __construct()
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

    public function getNombreTranslation(){
        if($this->translations['es'] !=  null){
            return $this->translations['es']->getNombre();
        }
        return;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
