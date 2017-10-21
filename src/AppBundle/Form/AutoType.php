<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modelo')
            ->add('pasajeros')
            ->add('puertas')
            ->add('aire')
            ->add('maletasGrandes')
            ->add('maletasPequenas')
            ->add('cdReproductor')
            ->add('usb')
            ->add('auxiliar')
            ->add('pad')
            ->add('pas')
            ->add('precio')
            ->add('image')
            ->add('updatedAt')
            ->add('transmision')
            ->add('categoria')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Auto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_auto';
    }
}
