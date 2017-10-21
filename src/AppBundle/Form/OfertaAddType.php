<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\AutoType;
use AppBundle\Form\Type\OfertaAutoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class OfertaAddType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations','a2lix_translations',array(
                'label' => 'Nombres',
                'required' => false,
            ))
            ->add('codigo')
            ->add('fechaInicio')
            ->add('fechaFin')
            ->add('activa')
            ->add('ofertaAutos', new OfertaAutoType(), array(
                'type' => new \AppBundle\Form\OfertaAutoType(),
                'cascade_validation' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation' => true,
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Oferta',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_oferta';
    }
}
