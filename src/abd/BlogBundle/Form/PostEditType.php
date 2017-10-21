<?php

namespace abd\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class PostEditType extends AbstractType
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
                    'titulo' => array(
                        'label' => 'Titulo',
                    ),
                    'texto' => array(
                        'label' => 'Texto',
                        'field_type' => 'ckeditor'
                    ),
                    'url' => array(
                        'label' => 'Url',
                    )
                ),

            ))
            ->add('imageFile','vich_image',array(
                'required' => false,
                'allow_delete' => false
            ))
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
