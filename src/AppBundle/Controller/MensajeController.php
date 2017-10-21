<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AlquilerWizard;
use AppBundle\Form\ComentarioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Mensaje;
use AppBundle\Form\MensajeType;

/**
 * Mensaje controller.
 *
 * @Route("/{_locale}/message",  defaults={"_locale" = "en"}, requirements={"_locale" = "en|es|fr"} )
 */
class MensajeController extends Controller
{

    /**
     * Creates a new Mensaje entity.
     *
     * @Route("/", name="mensaje_create")
     * @Method("POST")
     */
    public function createMensajeAction(Request $request)
    {
        $entity = new Mensaje();
        $form = $this->createMensajeForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository('AppBundle:MensajeTipo')->find(1);
            $estado = $em->getRepository('AppBundle:MensajeEstado')->find(1);
            $locale = $request->getLocale();
            $entity->setTipo($tipo);
            $entity->setEstado($estado);
            $entity->setLocale($locale);
            $entity->setTitulo("Mensaje de Contacto");
            $em->persist($entity);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'notification.contact_thanks');

            return $this->redirect($this->generateUrl('contactUs'));
        }

        $formData = new AlquilerWizard();

        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id
        $flow->bind($formData);

        $form_reserva = $flow->createForm();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'form_reserva' => $form_reserva->createView()
        );
    }

    /**
     * Creates a form to create a Mensaje entity.
     *
     * @param Mensaje $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createMensajeForm(Mensaje $entity)
    {
        $form = $this->createForm(new MensajeType(), $entity, array(
            'action' => $this->generateUrl('mensaje_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a Mensaje entity.
     *
     * @param Mensaje $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createComentarioForm(Mensaje $entity)
    {
        $form = $this->createForm(new ComentarioType(), $entity, array(
            'action' => $this->generateUrl('comment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    /**
     * Creates a new Mensaje entity.
     *
     * @Route("/comment", name="comment_create")
     * @Method("POST")
     */
    public function createComentarioAction(Request $request)
    {
        $entity = new Mensaje();
        $form = $this->createComentarioForm($entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();

        if ($form->isValid()) {

            $tipo = $em->getRepository('AppBundle:MensajeTipo')->find(2);
            $estado = $em->getRepository('AppBundle:MensajeEstado')->find(2);
            $entity->setTipo($tipo);
            $entity->setEstado($estado);
            $entity->setLocale($locale);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('testimonials'));
        }

        $entitiesQuery = $em->getRepository('AppBundle:Mensaje')->getComentariosAprobadosQuery($locale);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entitiesQuery, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return array(
            'entities' => $pagination,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}
