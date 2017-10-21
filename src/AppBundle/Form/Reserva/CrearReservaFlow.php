<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 25/02/2016
 * Time: 22:08
 */

namespace AppBundle\Form\Reserva;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;


class CrearReservaFlow extends FormFlow
{

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'Primer Paso',
                'form_type' => 'alquiler_primer_paso',
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    return $estimatedCurrentStepNumber > 1;
                },
            ),
            array(
                'label' => 'Segundo Paso',
                'form_type' => 'alquiler_segundo_paso',
            ),
            array(
                'label' => 'Tercer Paso',
                'form_type' => new TercerPasoType(),
            ),
            array(
                'label' => 'Confirmación',
            ),
        );
    }

}