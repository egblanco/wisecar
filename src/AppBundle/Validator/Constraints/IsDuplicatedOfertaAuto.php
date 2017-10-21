<?php
namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Oferta;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\CollectionValidator;

/**
 * @Annotation
 */
class IsDuplicatedOfertaAuto extends Constraint
{
    public $message = 'El auto con nombre "%string%" está duplicado.';

}