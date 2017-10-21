<?php
/**
 * Created by PhpStorm.
 * User: chuchu
 * Date: 25/02/2016
 * Time: 22:08
 */

namespace AppBundle\Form\Reserva;

use AppBundle\Entity\Cliente;
use Craue\FormFlowBundle\Event\PostBindFlowEvent;
use Craue\FormFlowBundle\Event\PostBindSavedDataEvent;
use Craue\FormFlowBundle\Event\PostValidateEvent;
use Craue\FormFlowBundle\Event\PreBindEvent;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowEvents;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ModificarReservaFlow extends FormFlow
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function hasStepData($step){
        return array_key_exists($step,$this->retrieveStepData());
    }

    protected function loadStepsConfig() {
        $request = $this->container->get('request');
        return array(
            array(
                'label' => 'Primer Paso',
                'form_type' => 'alquiler_primer_paso',
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    return true;
                },
            ),
            array(
                'label' => 'Segundo Paso',
                'form_type' => 'alquiler_segundo_paso',
                'form_options' => array(
                    'car_selected' => $request->getSession()->get('car_selected'),
                    'offert_code' => $request->getSession()->get('offert_code'),
                ),
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