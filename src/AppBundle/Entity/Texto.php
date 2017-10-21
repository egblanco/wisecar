<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Texto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TextoRepository")
 */
class Texto
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
     * @ORM\ManyToOne(targetEntity="TextoTipo", inversedBy="textos")
     * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id", nullable=false)
     *
     */
    private $tipo;

    private $translations;

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
     * Set tipo
     *
     * @param \AppBundle\Entity\TextoTipo $tipo
     * @return Texto
     */
    public function setTipo(\AppBundle\Entity\TextoTipo $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\TextoTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function getTituloTranslation(){
        if($this->translations['es'] !=  null){
            return $this->translations['es']->getTitulo();
        }
        return;
    }

    public function getTextoTranslation(){
        if($this->translations['es'] !=  null){
            return $this->translations['es']->getTexto();
        }
        return;
    }
}
