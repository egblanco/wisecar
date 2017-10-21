<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 29/02/2016
 * Time: 13:39
 */

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class AutoType extends AbstractType
{

    private $codigos;

    public function __construct($codigos)
    {
        $this->codigos = $codigos;
    }

    public function getParent()
    {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'auto';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'codes' => $this->codigos,
        ));
    }

}