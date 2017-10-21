<?php

namespace AppBundle\Form;

use AppBundle\Entity\Accesorio;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Seguro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AlquilerType extends AbstractType
{
    private $em;

    private $entity;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $auto = null;
        $accesorios = array();
        $seguros = array();
        if($this->entity->getId() != null){
            $alquilerDb = $this->em->getRepository('AppBundle:Alquiler')->getArticulos($this->entity->getId());
            foreach($alquilerDb->getAlquilerArticulos() as $alquilerArticulo){
                if($alquilerArticulo->getArticulo() instanceof Auto){
                    $auto = $alquilerArticulo->getArticulo();
                }elseif($alquilerArticulo->getArticulo() instanceof Accesorio){
                    $accesorios[] = $alquilerArticulo->getArticulo();
                }elseif($alquilerArticulo->getArticulo() instanceof Seguro){
                    $seguros[] = $alquilerArticulo->getArticulo();
                }
            }
        }
        $accesoriosList = $this->em->getRepository('AppBundle:Accesorio')->findAll();
        $segurosList = $this->em->getRepository('AppBundle:Seguro')->findAll();

        $builder->add('auto','entity', array(
                'class' => 'AppBundle:Auto',
                'data' => $auto,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('a');
                },
                'attr' => array(
                    'data-widget'=>'select2',
                ),
                'mapped' => false,
            ) )
            ->add('accesorios', 'choice', array(
                'choices' => $this->toArray($accesoriosList),
                /*'data' => $accesorios,*/
                'attr' => array(
                    'data-widget'=>'select2',
                ),
                'required' => false,
                'multiple' => true,
                'mapped' => false,
            ))
            ->add('seguros', 'choice', array(
                'choices' => $this->toArray($segurosList),
                'attr' => array(
                    'data-widget'=>'select2',
                ),
                'required' => false,
                'multiple' => true,
                'mapped' => false,
            ))
            ->add('oferta',null,array(
                'attr' => array(
                    'data-widget'=>'select2',
                ),
            ))
            ->add('fechaInicio')
            ->add('fechaFin')
            ->add('fechaFin')
            ->add('codigo')
            ->add('total')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Alquiler'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_alquiler';
    }

    public function setEm($em){
        $this->em = $em;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    private function toArray($collection){
        $array = array();
        foreach($collection as $item){
            $array[$item->getId()] = $item;
        }
        return $array;
    }
}
