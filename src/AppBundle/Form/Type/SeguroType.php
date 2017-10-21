<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 29/02/2016
 * Time: 13:39
 */

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeguroType extends AbstractType
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
        return 'seguro';
    }

}