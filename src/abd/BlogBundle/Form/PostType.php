<?php

namespace abd\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations','a2lix_translations',array(
                'label' => 'Traducciones',
                'required' => true,
                'fields' => array(
                    'titulo' => array(                   // [3.a]
                        'label' => 'Titulo',                     // [4]
                    ),
                    'texto' => array(                   // [3.a]
                        'label' => 'Texto',                     // [4]
                        'field_type' => 'ckeditor'
                    )),
                'exclude_fields' => array(
                    'url'
                )
            ))
            ->add('imageFile','vich_image')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'abd\BlogBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abd_blogbundle_post';
    }
}
