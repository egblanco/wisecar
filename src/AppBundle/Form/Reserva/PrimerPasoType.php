<?php

namespace AppBundle\Form\Reserva;

use AppBundle\Form\Type\AutoType;
use AppBundle\Form\Type\EntityTranslationType;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrimerPasoType extends AbstractType
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
        $codigosArr = $this->em->getRepository('AppBundle:Auto')->getAutoCodigos();
        $codigos = array();
        foreach ($codigosArr as $row) {
            $codigos[$row['id']] = $row['codigo'];
        }

        $builder
            ->add('lugarRecogida', new EntityTranslationType(), array(
                'class' => 'AppBundle:Lugar',
                'query_builder' => function (EntityRepository $er) use ($options){
                    return $er->createQueryBuilder('lugar')
                        ->select('lugar, translation')
                        ->innerJoin('lugar.translations','translation');
                },
                'property' => 'nombreTranslation',
                'required' => true
            ))
            ->add('samePlace','checkbox',array(
                'data' => true,
                'required' => false,
            ))
            ->add('lugarRegreso', new EntityTranslationType(), array(
                'class' => 'AppBundle:Lugar',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('lugar')
                        ->select('lugar, translation')
                        ->innerJoin('lugar.translations','translation');

                },
                'required' => false
            ))
            ->add('fechaInicio','datetime',array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy-H:mm',
                'required' => true,
                'attr' => array(
                    'class' => 'bttimepicker'
                )
            ))
            ->add('fechaFin','datetime',array(
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy-H:mm',
                'required' => true,
            ))
            ->add('auto', new AutoType($codigos), array(
                'class' => 'AppBundle:Auto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        /*->orderBy('u.username', 'ASC')*/;
                },
                'required' => true
            ))
            ->add('codigo')
        ;
    }

    public function getBlockPrefix() {
        return 'crearAlquilerStep1';
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AlquilerWizard'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'alquiler_primer_paso';
    }
}
