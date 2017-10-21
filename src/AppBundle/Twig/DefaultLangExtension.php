<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 07/04/2016
 * Time: 16:51
 */

namespace AppBundle\Twig;


class DefaultLangExtension extends \Twig_Extension
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'default_lang';
    }

    public function getFilters()
    {
        return array(
            'default_lang' => new \Twig_Filter_Method($this, 'defaultLangFilter'),
        );
    }
    public function defaultLangFilter($translations,$language, $default = null)
    {
        if($translations->containsKey($language)){
            return $translations[$language];
        }
        if($default == null){
            return $translations[$this->container->getParameter('locale')];
        }else{
            return $translations[$default];
        }

    }

}