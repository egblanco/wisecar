<?php

namespace AppBundle\Form\Reserva;

use AppBundle\Entity\Auto;
use AppBundle\Form\Type\AccesorioType;
use AppBundle\Form\Type\AutoType;
use AppBundle\Form\Type\EntityMultipleType;
use AppBundle\Form\Type\EntityTranslationType;
use AppBundle\Form\Type\SeguroType;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SegundoPasoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $codigos = array();
        if (array_key_exists('car_selected', $options) && array_key_exists('offert_code', $options)) {
            $codigosArr = $this->em->getRepository('AppBundle:Auto')
                ->getAutoCodigos($options['car_selected'], $options['offert_code']);
        } else {
            $codigosArr = $this->em->getRepository('AppBundle:Auto')
                ->getAutoCodigos();
        }

        foreach ($codigosArr as $row) {
            $codigos[$row['id']] = $row['codigo'];
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $alquilerWizard = $event->getData();
            $form = $event->getForm();


            if ($alquilerWizard->getSamePlace() == true) {
                $form->add('lugarRegreso', new EntityTranslationType(), array(
                    'class' => 'AppBundle:Lugar',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('lugar')
                            ->select('lugar, translation')
                            ->innerJoin('lugar.translations', 'translation');
                        #->where('translation.locale = :locale')
                        #->setParameter('locale', $this->locale );
                    },
                    'required' => false,
                ));
            } else {
                $form->add('lugarRegreso', new EntityTranslationType(), array(
                    'class' => 'AppBundle:Lugar',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('lugar')
                            ->select('lugar, translation')
                            ->innerJoin('lugar.translations', 'translation');
                        #->where('translation.locale = :locale')
                        #->setParameter('locale', $this->locale );
                    },
                    'required' => true,
                ));
            }
        });
        $builder
            ->add('lugarRecogida', new EntityTranslationType(), array(
                'class' => 'AppBundle:Lugar',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('lugar')
                        ->select('lugar, translation')
                        ->innerJoin('lugar.translations', 'translation');
                    #->where('translation.locale = :locale')
                    #->setParameter('locale', $this->locale );
                },
                'required' => true,
                'property' => 'object',
            ))
            ->add('samePlace', 'checkbox', array(
                'required' => false,
            ))
            ->add('fechaInicio', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy-H:mm',
                'required' => true,
            ))
            ->add('fechaFin', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy-H:mm',
                'required' => true,
            ))
            ->add('auto', new AutoType($codigos), array(
                'class' => 'AppBundle:Auto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('auto')
                        ->select('auto, transmision', 'translation')
                        ->innerJoin('auto.transmision', 'transmision')
                        ->innerJoin('transmision.translations', 'translation');
                },
                'required' => true
            ))
            ->add('codigo')
            ->add('accesorios', new AccesorioType(), array(
                'class' => 'AppBundle:Accesorio',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('accesorio')/*->orderBy('u.username', 'ASC')*/
                    ->select('accesorio, translation')
                        ->innerJoin('accesorio.translations', 'translation')
                        //->where('translation.locale = :locale')
                        //->setParameter('locale', $this->locale );
                        ;
                },
                'property' => 'object',
                'multiple' => true,
            ))
            ->add('seguros', new SeguroType(), array(
                'class' => 'AppBundle:Seguro',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('seguro')
                        ->select('seguro, translation')
                        ->innerJoin('seguro.translations', 'translation')
                        #->where('translation.locale = :locale')
                        #->setParameter('locale', $this->locale );
                        ;
                },
                'property' => 'object',
                'multiple' => true,
            ));

    }

    public function getBlockPrefix()
    {
        return 'crearAlquilerStep2';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AlquilerWizard'
        ))->setOptional(array(
            'car_selected', 'offert_code'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'alquiler_segundo_paso';
    }
}
