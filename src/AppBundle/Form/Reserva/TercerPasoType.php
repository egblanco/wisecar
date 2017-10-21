<?php

namespace AppBundle\Form\Reserva;

use AppBundle\Entity\Cliente;
use AppBundle\Form\ClienteType;
use AppBundle\Form\Type\AccesorioType;
use AppBundle\Form\Type\EntityMultipleType;
use AppBundle\Form\Type\SeguroType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TercerPasoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cliente = $options['data']->getCliente();
        $builder->add('cliente', new ClienteType(),array(
            'data'=> $cliente
        ));
    }

    public function getBlockPrefix() {
        return 'crearAlquilerStep3';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AlquilerWizard',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'alquiler_tercer_paso';
    }
}
