<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('fechaNacimiento',null,array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy-H:mm',
            ))
            ->add('sexo','choice',array(
                'choices'=> array(
                    'm' => "Male",
                    'f' => "Female"
                ),
            ))
            ->add('compania')
            ->add('telefono')
            ->add('correo','email')
            ->add('correoConfirmacion','email')
            ->add('fax')
            ->add('direccion')
            ->add('ciudad')
            ->add('estado')
            ->add('pais')
            ->add('zip')
            ->add('cantidadPersonas')
            ->add('enHotel')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cliente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_cliente';
    }
}
