<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class OfertaAutoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $oferta_auto = $event->getData();

                $form = $event->getForm();

                if ($oferta_auto != null && $oferta_auto->getOferta()->getTipo()->getId() == 1) {
                    $form->add('auto', null, array(
                        'attr' => array(
                            'readonly' => true
                        )
                    ));
                } else {
                    $form->add('auto', null, array(
                        'attr' => array(
                            'data-widget' => 'select2',
                            'readonly'=> false
                        )
                    ));

                }
                $form->add('precio')
                    ->add('semanal');
            });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\OfertaAuto',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_ofertaauto';
    }
}
