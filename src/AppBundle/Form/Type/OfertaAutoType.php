<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 29/02/2016
 * Time: 13:39
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaAutoType extends AbstractType
{

    public function getParent()
    {
        return 'collection';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'ofertaauto';
    }

}