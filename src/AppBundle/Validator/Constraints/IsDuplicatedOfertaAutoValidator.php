<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class IsDuplicatedOfertaAutoValidator extends ConstraintValidator
{
    public $message = 'El auto con nombre "%string%" está duplicado.';

    public function validate($values, Constraint $constraint)
    {
        for($i = 0 ; $i < count($values)-1; $i++){
            for($j = $i+1 ; $j < count($values); $j++){
                $ofertaI = $values[$i];
                $ofertaJ = $values[$j];

                if($ofertaI->getAuto()->getId() == $ofertaJ->getAuto()->getId()){
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('%string%', $ofertaI->getAuto())
                        ->addViolation();
                    break;
                }
            }
        }
    }
}