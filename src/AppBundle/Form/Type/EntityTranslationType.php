<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 29/02/2016
 * Time: 13:39
 */

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class EntityTranslationType extends AbstractType
{

    public function getParent()
    {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'entity_translation';
    }

}