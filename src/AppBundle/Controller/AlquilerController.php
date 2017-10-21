<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accesorio;
use AppBundle\Entity\AlquilerArticulo;
use AppBundle\Entity\AlquilerUpdate;
use AppBundle\Entity\AlquilerWizard;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\OfertaAuto;
use AppBundle\Entity\Seguro;
use AppBundle\Form\AlquilerUpdateType;
use AppBundle\Form\Reserva\SegundoPasoType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Alquiler;
use AppBundle\Form\AlquilerType;
use Symfony\Component\HttpFoundation\Response;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Alquiler controller.
 *
 * @Route( "/{_locale}/rent",  defaults={"_locale" = "en"}, requirements={"_locale" = "en|es|fr"} )
 */
class AlquilerController extends Controller
{
    /**
     * Lists all Test entities.
     *
     * @Route("/new", name="wizard")
     * @Method({"GET","POST"})
     * @I18nDoctrine
     */
    public function createAlquilerAction(Request $request)
    {
        $alquilerWizard = new AlquilerWizard(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id

        $flow->bind($alquilerWizard);

        if ($request->getMethod() == 'GET' && $flow->getCurrentStepNumber() != null && $flow->getCurrentStepNumber() == 1) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        // form of the current step
        $form = $flow->createForm();

        $em = $this->getDoctrine()->getManager();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep() != null) {
                if ($flow->getCurrentStepNumber() == 4) {
                    $auto = $alquilerWizard->getAuto();
                    $accesorios = $alquilerWizard->getAccesorios();
                    $seguros = $alquilerWizard->getSeguros();
                    $codigo = $alquilerWizard->getCodigo();
                    $lugarRecogida = $alquilerWizard->getLugarRecogida();
                    $lugarRegreso = $alquilerWizard->getLugarRegreso();
                    if($alquilerWizard->getSamePlace() == true){
                        $lugarRegreso = $lugarRecogida;
                    }

                    $fechaInicio = $alquilerWizard->getFechaInicio()->getTimestamp()*1000;
                    $fechaFin = $alquilerWizard->getFechaFin()->getTimestamp()*1000;

                    $oferta = $em->getRepository('AppBundle:Oferta')->getOfertaByCode($codigo);
                    $ofertaAuto = null;
                    $ofertasAuto = $auto->getOfertaAutos();

                    foreach ($ofertasAuto as $ofertaAutoTemp) {
                        if ($ofertaAutoTemp->getOferta()->getCodigo() == $codigo) {
                            $ofertaAuto = $ofertaAutoTemp;
                            break;
                        }
                    }

                    if ($ofertaAuto == null) {
                        throw $this->createNotFoundException('Unable to find Offert entity of code ' . $codigo . ' for car ' . $auto->getId());
                    }

                    $result = $this->get('auto.service')->getPrice($auto, $lugarRecogida, $lugarRegreso, $accesorios, $seguros,
                        $ofertaAuto, $fechaInicio, $fechaFin);
                    //aqui se calcula el precio
                    //$total = 0;
                    $alquilerWizard->setTotal($result['total']);
                }
                $form = $flow->createForm();
            } else {
                $alquiler = new Alquiler();
                $alquiler->setCodigo(uniqid());
                $alquiler->setFechaInicio($alquilerWizard->getFechaInicio());
                $alquiler->setFechaFin($alquilerWizard->getFechaFin());
                $alquiler->setLugarRecogida($alquilerWizard->getLugarRecogida());
                $alquiler->setLugarRegreso($alquilerWizard->getLugarRegreso());
                if ($alquilerWizard->getSamePlace() == true) {
                    $alquiler->setLugarRegreso($alquilerWizard->getLugarRecogida());
                }
                $alquiler->setCliente($alquilerWizard->getCliente());

                $oferta = $em->getRepository('AppBundle:Oferta')->findOneBy(
                    array('codigo' => $alquilerWizard->getCodigo()));
                $alquiler->setOferta($oferta);

                $auto = $alquilerWizard->getAuto();
                $ofertaAuto = null;
                $ofertasAuto = $auto->getOfertaAutos();

                foreach ($ofertasAuto as $ofertaAutoTemp) {
                    if ($ofertaAutoTemp->getOferta()->getCodigo() == $alquilerWizard->getCodigo()) {
                        $ofertaAuto = $ofertaAutoTemp;
                        break;
                    }
                }

                if ($ofertaAuto == null) {
                    throw $this->createNotFoundException('Unable to find Offert entity of code ' . $alquilerWizard->getCodigo() . ' for car ' . $auto->getId());
                }

                $result = $this->get('auto.service')->getPrice($alquilerWizard->getAuto(), $alquilerWizard->getLugarRecogida(),
                    $alquiler->getLugarRegreso(), $alquilerWizard->getAccesorios(), $alquilerWizard->getSeguros(), $ofertaAuto,
                    $alquilerWizard->getFechaInicio()->getTimestamp()*1000,$alquilerWizard->getFechaFin()->getTimestamp()*1000);
                $alquiler->setTotal($result['total']);

                $alquilerArticulo = new AlquilerArticulo();
                $alquilerArticulo->setAlquiler($alquiler);
                $alquilerArticulo->setArticulo($alquilerWizard->getAuto());
                $alquilerArticulo->setPrecio($result['auto']);
                $alquiler->addAlquilerArticulo($alquilerArticulo);

                $em->persist($alquiler->getCliente());
                $em->persist($alquilerArticulo);

                foreach ($alquilerWizard->getAccesorios() as $accesorio) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($accesorio);
                    $alquilerArticulo->setPrecio($accesorio->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                foreach ($alquilerWizard->getSeguros() as $seguro) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($seguro);
                    $alquilerArticulo->setPrecio($seguro->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                $em->persist($alquiler);
                $em->flush();

                $flow->reset(); // remove step data from the session

                //                TODO EMAIL HERE

                return $this->redirect($this->generateUrl('alquiler_show', array('id' => $alquiler->getId())));
            }
        }

        $em = $this->getDoctrine()->getManager();
        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('@App/Alquiler/wizard.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'formData' => $alquilerWizard,
            'ofertaAutos' => $ofertaAutos,
            'results' => $results

        ));
    }

    /**
     * Displays a form to create a new AlquilerUpdate entity.
     *
     * @Route("/search", name="alquiler_search")
     * @Method("GET")
     * @Template()
     */
    public function searchAction()
    {
        $entity = new AlquilerUpdate();
        $form = $this->createUpdateForm($entity);

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        $result = array(
            'entity' => $entity,
            'form' => $form->createView(),
            'results' => $results
        );

        return $this->render('@App/Alquiler/search.html.twig', $result);
    }

    private function createUpdateForm(AlquilerUpdate $entity)
    {
        $form = $this->createForm(new AlquilerUpdateType(), $entity, array(
            'action' => $this->generateUrl('alquiler_find'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Buscar', 'attr' => array(
            'class' => 'btn text-go-button',
        )));

        return $form;
    }

    /**
     * Creates a new Alquiler entity.
     *
     * @Route("/", name="alquiler_find")
     * @Method("POST")
     * @Template("AppBundle:Alquiler:search.html.twig")
     */
    public function showUpdateAction(Request $request)
    {
        $entity = new AlquilerUpdate();

        $form = $this->createUpdateForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $correo = $entity->getCorreo();
            $codigo = $entity->getCodigo();

            $em = $this->getDoctrine()->getManager();
            $alquiler = $em->getRepository('AppBundle:Alquiler')->getByEmailCode($correo, $codigo);

            if ($alquiler) {
                return $this->redirect($this->generateUrl('alquiler_show', array('id' => $alquiler->getId())));
            } else {
                $session = $request->getSession();
                $session->getFlashBag()->add('error', 'El código o el correo es incorrecto');
                return $this->redirect($this->generateUrl('alquiler_search'));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="alquiler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Alquiler')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alquiler_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array(
                'class' => 'btn text-go-button'
            )))
            ->getForm();
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/edit/{id}", name="wizard_update")
     * @Method({"GET","POST"})
     */
    public function updateAlquilerAction($id, Request $request)
    {
        $alquilerWizard = new AlquilerWizard(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->get('app.form.flow.modificar_alquiler'); // must match the flow's service id

        $flow->bind($alquilerWizard);

        $em = $this->getDoctrine()->getManager();

        if ($flow->getCurrentStepNumber() == 2 && !$flow->hasStepData(2)) {
            $alquiler = $em->getRepository('AppBundle:Alquiler')->find($id);
            $alquilerWizard->setFechaInicio($alquiler->getFechaInicio());
            $alquilerWizard->setFechaFin($alquiler->getFechaFin());
            $alquilerWizard->setLugarRecogida($alquiler->getLugarRecogida());
            if ($alquiler->getLugarRecogida()->getId() == $alquiler->getLugarRegreso()->getId()) {
                $alquilerWizard->setSamePlace(true);
            }
            $alquilerWizard->setLugarRegreso($alquiler->getLugarRegreso());
            $alquilerWizard->setCodigo($alquiler->getOferta()->getCodigo());
            foreach ($alquiler->getAlquilerArticulos() as $alquilerArticulo) {
                if ($alquilerArticulo->getArticulo() instanceof Auto) {
                    $alquilerWizard->setAuto($alquilerArticulo->getArticulo());
                } elseif ($alquilerArticulo->getArticulo() instanceof Accesorio) {
                    $alquilerWizard->addAccesorio($alquilerArticulo->getArticulo());
                } elseif ($alquilerArticulo->getArticulo() instanceof Seguro) {
                    $alquilerWizard->addSeguro($alquilerArticulo->getArticulo());
                }
            }
        }else if ($flow->getCurrentStepNumber() == 4) {
            $auto = $alquilerWizard->getAuto();
            $accesorios = $alquilerWizard->getAccesorios();
            $seguros = $alquilerWizard->getSeguros();
            $codigo = $alquilerWizard->getCodigo();
            $lugarRecogida = $alquilerWizard->getLugarRecogida();
            $lugarRegreso = $alquilerWizard->getLugarRegreso();
            if($alquilerWizard->getSamePlace() == true){
                $lugarRegreso = $lugarRecogida;
            }

            $fechaInicio = $alquilerWizard->getFechaInicio()->getTimestamp()*1000;
            $fechaFin = $alquilerWizard->getFechaFin()->getTimestamp()*1000;

            $oferta = $em->getRepository('AppBundle:Oferta')->getOfertaByCode($codigo);
            $ofertaAuto = null;
            $ofertasAuto = $auto->getOfertaAutos();

            foreach ($ofertasAuto as $ofertaAutoTemp) {
                if ($ofertaAutoTemp->getOferta()->getCodigo() == $codigo) {
                    $ofertaAuto = $ofertaAutoTemp;
                    break;
                }
            }

            if ($ofertaAuto == null) {
                throw $this->createNotFoundException('Unable to find Offert entity of code ' . $codigo . ' for car ' . $auto->getId());
            }

            $result = $this->get('auto.service')->getPrice($auto, $lugarRecogida, $lugarRegreso, $accesorios, $seguros,
                $ofertaAuto, $fechaInicio, $fechaFin);
            //aqui se calcula el precio
            //$total = 0;
            $alquilerWizard->setTotal($result['total']);
        }
        // form of the current step
        $form = $flow->createForm();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep() != null) {
                if ($flow->getCurrentStepNumber() == 3 && !$flow->hasStepData(3)) {
                    $alquiler = $em->getRepository('AppBundle:Alquiler')->find($id);
                    $alquilerWizard->setCliente($alquiler->getCliente());
                }

                $form = $flow->createForm();
            } else {
                $alquiler = $em->getRepository('AppBundle:Alquiler')->find($id);
                $alquiler->setFechaInicio($alquilerWizard->getFechaInicio());
                $alquiler->setFechaFin($alquilerWizard->getFechaFin());
                $alquiler->setLugarRecogida($alquilerWizard->getLugarRecogida());
                if ($alquilerWizard->getSamePlace()) {
                    $alquiler->setLugarRegreso($alquilerWizard->getLugarRecogida());
                } else {
                    $alquiler->setLugarRegreso($alquilerWizard->getLugarRegreso());
                }

                $em->remove($alquiler->getCliente());

                $alquiler->setCliente($alquilerWizard->getCliente());
                $em->persist($alquiler->getCliente());

                foreach ($alquiler->getAlquilerArticulos() as $alquilerArticulo) {
                    $em->remove($alquilerArticulo);
                }

                $auto = $alquilerWizard->getAuto();
                $ofertaAuto = null;
                $ofertasAuto = $auto->getOfertaAutos();

                foreach ($ofertasAuto as $ofertaAutoTemp) {
                    if ($ofertaAutoTemp->getOferta()->getCodigo() == $alquilerWizard->getCodigo()) {
                        $ofertaAuto = $ofertaAutoTemp;
                        break;
                    }
                }

                if ($ofertaAuto == null) {
                    throw $this->createNotFoundException('Unable to find Offert entity of code ' . $alquilerWizard->getCodigo() . ' for car ' . $auto->getId());
                }

                $result = $this->get('auto.service')->getPrice($alquilerWizard->getAuto(), $alquilerWizard->getLugarRecogida(),
                    $alquiler->getLugarRegreso(), $alquilerWizard->getAccesorios(), $alquilerWizard->getSeguros(), $ofertaAuto,
                    $alquilerWizard->getFechaInicio()->getTimestamp()*1000,$alquilerWizard->getFechaFin()->getTimestamp()*1000);
                $alquiler->setTotal($result['total']);

                $alquilerArticulo = new AlquilerArticulo();
                $alquilerArticulo->setAlquiler($alquiler);
                $alquilerArticulo->setArticulo($alquilerWizard->getAuto());
                $alquilerArticulo->setPrecio($result['auto']);
                $alquiler->addAlquilerArticulo($alquilerArticulo);
                $em->persist($alquilerArticulo);


                foreach ($alquilerWizard->getAccesorios() as $accesorio) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($accesorio);
                    $alquilerArticulo->setPrecio($accesorio->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                foreach ($alquilerWizard->getSeguros() as $seguro) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($seguro);
                    $alquilerArticulo->setPrecio($seguro->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                $oferta = $em->getRepository('AppBundle:Oferta')->findOneBy(
                    array('codigo' => $alquilerWizard->getCodigo()));
                $alquiler->setOferta($oferta);

                $em->flush();

                $flow->reset(); // remove step data from the session

                $em = $this->getDoctrine()->getManager();
                $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();

                //                TODO EMAIL HERE

                return $this->redirect($this->generateUrl('alquiler_show', array('id' => $alquiler->getId(), 'ofertaAutos' => $ofertaAutos))); // redirect when done
            }
        }

        $em = $this->getDoctrine()->getManager();
        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('@App/Alquiler/wizard.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'formData' => $alquilerWizard,
            'ofertaAutos' => $ofertaAutos,
            'results' => $results

        ));
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/start/{id}/{codigo}", name="wizard_start")
     * @Method({"GET"})
     */
    public function startAlquilerAction(Request $request, $id, $codigo)
    {
        $request->getSession()->set('car_selected', $id);
        $request->getSession()->set('offert_code', $codigo);

        return $this->redirect($this->generateUrl('wizard_create'));

    }

    /**
     * Lists all Test entities.
     *
     * @Route("/start_bakend/{entity}/{id}", name="wizard_start_backend")
     * @Method({"GET"})
     */
    public function startAlquilerBackendAction(Request $request, $entity, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $alquiler = $em->getRepository('AppBundle:Alquiler')->getOferta($id);

        $request->getSession()->set('car_selected', $alquiler->getAuto()->getId());
        $request->getSession()->set('offert_code', $alquiler->getOferta()->getCodigo());

        return $this->redirect($this->generateUrl('wizard_create'));
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/create", name="wizard_create")
     * @Method({"GET","POST"})
     */
    public function updateSessionAlquilerAction(Request $request)
    {
        $alquilerWizard = new AlquilerWizard(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->get('app.form.flow.crear_alquiler_dirigida'); // must match the flow's service id

        $flow->bind($alquilerWizard);

        $em = $this->getDoctrine()->getManager();

        if ($flow->getCurrentStepNumber() == 2) {
            $id = $request->getSession()->get('car_selected');
            $code = $request->getSession()->get('offert_code');
            if ($id == null) {
                throw $this->createNotFoundException('No car selected');
            }
            $auto = $em->getRepository('AppBundle:Auto')->getAutoOfertas($id);
            $alquilerWizard->setAuto($auto);
            $ofertaAutos = $auto->getOfertaAutos();
            foreach ($ofertaAutos as $ofertaAuto) {
                $oferta = $ofertaAuto->getOferta();
                if ($oferta->getCodigo() == $code) {
                    $alquilerWizard->setCodigo($oferta->getCodigo());
                }
            }
            if ($alquilerWizard->getCodigo() == null) {
                throw $this->createNotFoundException('Unable to find an offert for car ' . $auto->getId() . ' of code ' . $code . '.');
            }
        }
        // form of the current step
        $form = $flow->createForm();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep() != null) {
                if ($flow->getCurrentStepNumber() == 4) {
                    $auto = $alquilerWizard->getAuto();
                    $accesorios = $alquilerWizard->getAccesorios();
                    $seguros = $alquilerWizard->getSeguros();
                    $codigo = $alquilerWizard->getCodigo();
                    $lugarRecogida = $alquilerWizard->getLugarRecogida();
                    $lugarRegreso = $alquilerWizard->getLugarRegreso();
                    if($alquilerWizard->getSamePlace() == true){
                        $lugarRegreso = $lugarRecogida;
                    }

                    $fechaInicio = $alquilerWizard->getFechaInicio()->getTimestamp()*1000;
                    $fechaFin = $alquilerWizard->getFechaFin()->getTimestamp()*1000;

                    $oferta = $em->getRepository('AppBundle:Oferta')->getOfertaByCode($codigo);
                    $ofertaAuto = null;
                    $ofertasAuto = $auto->getOfertaAutos();

                    foreach ($ofertasAuto as $ofertaAutoTemp) {
                        if ($ofertaAutoTemp->getOferta()->getCodigo() == $codigo) {
                            $ofertaAuto = $ofertaAutoTemp;
                            break;
                        }
                    }

                    if ($ofertaAuto == null) {
                        throw $this->createNotFoundException('Unable to find Offert entity of code ' . $codigo . ' for car ' . $auto->getId());
                    }

                    $result = $this->get('auto.service')->getPrice($auto, $lugarRecogida, $lugarRegreso, $accesorios, $seguros,
                        $ofertaAuto, $fechaInicio, $fechaFin);
                    //aqui se calcula el precio
                    //$total = 0;
                    $alquilerWizard->setTotal($result['total']);
                }
                $form = $flow->createForm();
            } else {
                $alquiler = new Alquiler();
                $alquiler->setCodigo(uniqid());
                $alquiler->setFechaInicio($alquilerWizard->getFechaInicio());
                $alquiler->setFechaFin($alquilerWizard->getFechaFin());
                $alquiler->setLugarRecogida($alquilerWizard->getLugarRecogida());
                $alquiler->setLugarRegreso($alquilerWizard->getLugarRegreso());
                $alquiler->setCliente($alquilerWizard->getCliente());

                $em = $this->getDoctrine()->getManager();
                $em->persist($alquiler->getCliente());

                $auto = $alquilerWizard->getAuto();
                $ofertaAuto = null;
                $ofertasAuto = $auto->getOfertaAutos();

                foreach ($ofertasAuto as $ofertaAutoTemp) {
                    if ($ofertaAutoTemp->getOferta()->getCodigo() == $alquilerWizard->getCodigo()) {
                        $ofertaAuto = $ofertaAutoTemp;
                        break;
                    }
                }

                if ($ofertaAuto == null) {
                    throw $this->createNotFoundException('Unable to find Offert entity of code ' . $alquilerWizard->getCodigo() . ' for car ' . $auto->getId());
                }

                $result = $this->get('auto.service')->getPrice($alquilerWizard->getAuto(), $alquilerWizard->getLugarRecogida(),
                    $alquiler->getLugarRegreso(), $alquilerWizard->getAccesorios(), $alquilerWizard->getSeguros(), $ofertaAuto,
                    $alquilerWizard->getFechaInicio()->getTimestamp()*1000,$alquilerWizard->getFechaFin()->getTimestamp()*1000);
                $alquiler->setTotal($result['total']);

                $alquilerArticulo = new AlquilerArticulo();
                $alquilerArticulo->setAlquiler($alquiler);
                $alquilerArticulo->setArticulo($alquilerWizard->getAuto());
                $alquilerArticulo->setPrecio($result['auto']);
                $alquiler->addAlquilerArticulo($alquilerArticulo);
                $em->persist($alquilerArticulo);


                foreach ($alquilerWizard->getAccesorios() as $accesorio) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($accesorio);
                    $alquilerArticulo->setPrecio($accesorio->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                foreach ($alquilerWizard->getSeguros() as $seguro) {
                    $alquilerArticulo = new AlquilerArticulo();
                    $alquilerArticulo->setAlquiler($alquiler);
                    $alquilerArticulo->setArticulo($seguro);
                    $alquilerArticulo->setPrecio($seguro->getPrecio());
                    $alquiler->addAlquilerArticulo($alquilerArticulo);
                    $em->persist($alquilerArticulo);
                }

                $oferta = $em->getRepository('AppBundle:Oferta')->findOneBy(
                    array('codigo' => $alquilerWizard->getCodigo()));
                $alquiler->setOferta($oferta);

                $em->persist($alquiler);
                $em->flush();

                $flow->reset(); // remove step data from the session

//                TODO EMAIL HERE

                return $this->redirect($this->generateUrl('alquiler_show', array('id' => $alquiler->getId())));
            }
        }

        $cars = $em->getRepository('AppBundle:Oferta')->getOfertasByType(1);
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();

        return $this->render('@App/Alquiler/wizard.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'formData' => $alquilerWizard,
            'ofertaAutos' => $ofertaAutos,
            'results' => $results
        ));
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/price/{recogida}/{regreso}/{id}/{accesorios}/{seguros}/{codigo}/{fechaini}/{fechafin}", name="price")
     * @Method("POST")
     */
    public function priceAction($recogida, $regreso, $id, $accesorios, $seguros, $codigo, $fechaini, $fechafin)
    {
        $arrayAccesorios = array();
        $arraySeguros = array();

        if ($accesorios != "0")
            $arrayAccesorios = preg_split('/,/', $accesorios);
        if ($seguros != "0")
            $arraySeguros = preg_split('/,/', $seguros);

        $em = $this->getDoctrine()->getManager();

        try {
            //obtener auto con sus ofertas
            $auto = $em->getRepository('AppBundle:Auto')->getAutoOfertas($id);
            $ofertaAuto = null;
            $ofertasAuto = $auto->getOfertaAutos();

            foreach ($ofertasAuto as $ofertaAutoTemp) {
                if ($ofertaAutoTemp->getOferta()->getCodigo() == $codigo) {
                    $ofertaAuto = $ofertaAutoTemp;
                    break;
                }
            }

            if ($ofertaAuto == null) {
                throw $this->createNotFoundException('Unable to find Offert entity of code ' . $codigo . ' for car ' . $id);
            }

            $accesorios = $em->getRepository('AppBundle:Accesorio')->getIdIn($arrayAccesorios);

            $seguros = $em->getRepository('AppBundle:Seguro')->getIdIn($arraySeguros);

            $lugarRecogida = $em->getRepository('AppBundle:Lugar')->find($recogida);

            $lugarRegreso = $em->getRepository('AppBundle:Lugar')->find($regreso);

            $result = $this->get('auto.service')->getPrice($auto, $lugarRecogida, $lugarRegreso, $accesorios, $seguros,
                $ofertaAuto, $fechaini, $fechafin);

            $return = array("responseCode" => 200, "subtotal" => $result['subtotal'], "tax" => $result['tax'],
                "total" => $result['total'], "seguros" => $result['seguros'], "accesorios" => $result['accesorios'], "insurance" => $result['insurance']);
        } catch (\Exception $e) {
            $return = array("responseCode" => 400, 'text' => $e->getMessage());
        }

        $return = json_encode($return);
        return new Response($return, 200, array('Content-Type' => 'application/json')); //make sure it has the correct content type


    }

    /**
     * Finds and displays a Alquiler entity.
     *
     * @Route("/{id}", name="alquiler_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Alquiler')->find($id);

        $deleteForm = $this->createDeleteForm($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alquiler entity.');
        }

        $accesorios = array();
        $cont = 0;

        foreach ($entity->getAlquilerArticulos() as $item) {
            if (!($item->getArticulo() instanceof Auto))
                $accesorios[$cont] = $item->getArticulo();
            $cont++;
        }

        return array(
            'entity' => $entity,
            'accesorios' => $accesorios,
            'delete_form' => $deleteForm->createView(),
        );
    }
}
