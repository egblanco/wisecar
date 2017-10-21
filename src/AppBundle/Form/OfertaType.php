<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\AutoType;
use AppBundle\Form\Type\OfertaAutoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $oferta = $options['data'];
        $builder
            ->add('translations','a2lix_translations',array(
                'label' => 'Nombres',
                'required' => $oferta->getTipo()->getId() == 1
            ))
            ->add('codigo')
            ->add('fechaInicio')
            ->add('fechaFin')
            ->add('activa')
            ->add('ofertaAutos', new OfertaAutoType(), array(
                'type' => new \AppBundle\Form\OfertaAutoType(),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Oferta',
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
