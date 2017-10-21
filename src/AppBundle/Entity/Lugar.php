<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lugar
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Lugar
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
     * @var integer
     *
     * @ORM\Column(name="iva", type="integer")
     */
    private $iva;

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

    /**
     * Set iva
     *
     * @param integer $iva
     * @return Lugar
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return integer 
     */
    public function getIva()
    {
        return $this->iva;
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

    public function getObject()
    {
        return $this;
    }

    /*public function __call($method, $args)
    {
        if (!method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get'. ucfirst($method);
        }

        return $this->proxyCurrentLocaleTranslation($method, $args);
    }*/
}
