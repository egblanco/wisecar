<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 07/04/2016
 * Time: 16:51
 */

namespace AppBundle\Twig;


use AppBundle\Entity\Accesorio;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Seguro;

class InstanceExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_extension_instance';
    }

    public function getTests ()
    {
        return [
            new \Twig_SimpleTest('auto', function ($object) { return $object instanceof Auto; }),
            new \Twig_SimpleTest('accesorio', function ($object) { return $object instanceof Accesorio; }),
            new \Twig_SimpleTest('seguro', function ($object) { return $object instanceof Seguro; })
        ];
    }

}