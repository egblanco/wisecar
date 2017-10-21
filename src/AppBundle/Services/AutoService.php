<?php
/**
 * Created by PhpStorm.
 * User: chuchus
 * Date: 26/03/2015
 * Time: 21:39
 */

namespace AppBundle\Services;


use AppBundle\Entity\Auto;
use AppBundle\Entity\Lugar;
use AppBundle\Entity\OfertaAuto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AutoService
{

    /**
     * @param Auto $auto Auto del que se desea calcular el precio
     * @param $codigoTipo                   Código del tipo de oferta por el cual se escoge al auto
     * @param Lugar $recogida Lugar de recogida en caso de que se haya seleccionado uno
     * @param Lugar $regreso Lugar de regreso en caso de que se haya seleccionado uno
     * @param Collection $accesorios Accesorios incluidos
     * @param Collection $seguros Seguros incluidos
     */
    public function getPrice(Auto $auto, Lugar $recogida, Lugar $regreso,
                             $accesorios, $seguros, OfertaAuto $ofertaAuto, $fechaInicio, $fechaFin)
    {
        //Por defecto el precio es el que tenga asociado el auto
        $precioAuto = $auto->getPrecio();

        //numero a convertir en dias
        $dias = $fechaFin - $fechaInicio;
        //calcula la cantidad exacta de dias entre el final y el fin de las fechas seleccionadas
        $diasDif = ceil($dias / (1000 * 60 * 60 * 24));

        $diasRestoSemana = $diasDif;
        //Se calcula la cantidad de semanas
        $semanas = floor($diasDif / 7);
        //Se calculan los dias que sobran luego de las semanas
        if ($semanas > 0) {
            $diasRestoSemana = $diasDif - ($semanas * 7);
        }
        //calcula precio del auto teniendo en cuenta si la cantidad de semanas es mayor que 1
        if ($semanas > 0) {
            $precioAuto = $semanas * $ofertaAuto->getSemanal() + $diasRestoSemana * $ofertaAuto->getPrecio();
        } else {
            $precioAuto = $diasRestoSemana * $ofertaAuto->getPrecio();
        }

        //precios de accesorios
        $precioAccesorios = 0;
        foreach ($accesorios as $accesorio) {
            $precioAccesorios += $accesorio->getPrecio();
        }

        //precios de seguros
        $precioSeguros = 0;
        foreach ($seguros as $seguro) {
            $precioSeguros += $seguro->getPrecio();
        }

        $stateTax = 0;

        $total = array(
            'auto' => $precioAuto,
            'accesorios' => $precioAccesorios,
            'seguros' => $precioSeguros,
            'tax' => $stateTax,
            'total' => $precioAuto + $precioAccesorios + $precioSeguros + $stateTax,
            'subtotal' => $precioAccesorios + $precioSeguros + $stateTax,
            'insurance' => $precioAccesorios + $precioSeguros
        );

        return $total;

    }

}