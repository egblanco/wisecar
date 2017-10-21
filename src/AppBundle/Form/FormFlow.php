<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 02/03/2016
 * Time: 13:49
 */

namespace AppBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow as BaseFlow;


class FormFlow extends BaseFlow
{
    public function hasStepData($step){
        return array_key_exists($step,$this->retrieveStepData());
    }
}