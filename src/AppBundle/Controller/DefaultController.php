<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alquiler;
use AppBundle\Entity\AlquilerWizard;
use AppBundle\Entity\Mensaje;
use AppBundle\Form\ComentarioType;
use AppBundle\Form\MensajeType;
use AppBundle\Form\Reserva\PrimerPasoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\OfertaAuto;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $formData = new AlquilerWizard();

        $em = $this->getDoctrine()->getManager();
        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();
        $accesorios = $em->getRepository('AppBundle:Accesorio')->findAll();

        $locale = $request->getLocale();

        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id

        $flow->bind($formData);


        $form = $flow->createForm();

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('abdBlogBundle:Post')->getFrontPost($locale);

        $gallery = $em->getRepository('abdBlogBundle:Post')->getImageGallery();

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:index.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'posts' => $posts,
            'gallery' => $gallery,
            'ofertaAutos' => $ofertaAutos,
            'results' => $results,
            'accesorios' => $accesorios
        ));
    }

    /**
     * @Route("/test", name="homepaget")
     */
    public function testAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('base_test.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function carsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('AppBundle:Auto')->findAll();
        $ofertas = $em->getRepository('AppBundle:Oferta')->findAll();
        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();
        $ofertaTipo = $em->getRepository('AppBundle:OfertaTipo')->findAll();
        $cars = $em->getRepository('AppBundle:Oferta')->getOfertasByType(1);


        $arrayTemp = array();
        $cont = 0;
        foreach ($cars as $car) {
            if ($car->getOferta()->getFechaFin() >= \DateTime::createFromFormat('Y-m-d H:m:s', date('Y-m-d H:m:s')) &&
                $car->getOferta()->getFechaInicio() <= \DateTime::createFromFormat('Y-m-d H:m:s', date('Y-m-d H:m:s'))
            ) {
                $arrayTemp[$cont] = $car;
                $cont++;
            }
        }
        $cars = array();
        $cars = $arrayTemp;


        // replace this example code with whatever you need
        return $this->render('AppBundle:default:cars.html.twig', array(
            'result' => $result, 'ofertaAutos' => $ofertaAutos, 'cars' => $cars
        ));
    }

    /**
     * @Route("/carsTest", name="carsTest")
     */
    public function carsTestAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:carsTest.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }


    public function ratesAction(Request $request)
    {
//        // replace this example code with whatever you need
//
        $em = $this->getDoctrine()->getManager();

        $locale = $request->getLocale();

        $autos = $em->getRepository('AppBundle:Auto')->findAll();

        $ofertas = $em->getRepository('AppBundle:Oferta')->getOfertaAutos(1);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $autos, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            1/*limit per page*/
        );

        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:rates.html.twig', array(
            'ofertas' => $ofertas,
            'autos' => $pagination,
            'results' => $results
        ));
    }

    public function postAction(Request $request)
    {
//        // replace this example code with whatever you need
//
        $em = $this->getDoctrine()->getManager();

        $locale = $request->getLocale();

        $autos = $em->getRepository('AppBundle:Auto')->findAll();

        $ofertas = $em->getRepository('AppBundle:Oferta')->getOfertaAutos(1);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $autos, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:post.html.twig', array(
            'ofertas' => $ofertas,
            'autos' => $pagination,
            'results' => $results
        ));
    }

    public function greatDealsAction(Request $request)
    {
        $formData = new AlquilerWizard();
        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id
        $flow->bind($formData);

        $form_reserva = $flow->createForm();

        $em = $this->getDoctrine()->getManager();
        $ofertaAutos = $em->getRepository('AppBundle:OfertaAuto')->findAll();

        $em = $this->getDoctrine()->getManager();
        $gd = $em->getRepository('AppBundle:Oferta')->getOfertasByType(2);
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:greatDeals.html.twig', array(

            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),

            'form_reserva' => $form_reserva->createView(), 'ofertaAutos' => $ofertaAutos, 'results' => $results,
            'gd' => $gd

        ));
    }

    public function contactUsAction(Request $request)
    {
        $entity = new Mensaje();
        $form = $this->createMensajeForm($entity);

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:contactUs.html.twig', array(
            'entity' => $entity,
            'results' => $results,
            'form' => $form->createView(),
        ));
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

        $form->add('submit', 'submit', array('label' => 'Send'));

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

    public function testimonialsAction(Request $request)
    {

        $entity = new Mensaje();
        $form = $this->createComentarioForm($entity);

        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
        $entitiesQuery = $em->getRepository('AppBundle:Mensaje')->getComentariosAprobadosQuery($locale);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $entitiesQuery, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        return $this->render('AppBundle:default:testimonials.html.twig', array(
            'entities' => $pagination,
            'entity' => $entity,
            'results' => $results,
            'form' => $form->createView()

        ));
    }

    public function travelTipsAction(Request $request)
    {

        $formData = new AlquilerWizard();
        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id
        $flow->bind($formData);

        $form_reserva = $flow->createForm();
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        $locale = $request->getLocale();

        $tips = $em->getRepository('AppBundle:Texto')->getTextoByTipo(2,$locale);
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $tips, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:default:travelTips.html.twig', array(

            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'tips' => $pagination,
            'form_reserva' => $form_reserva->createView(),
            'results' => $results

        ));
    }

    public function faqsAction(Request $request)
    {

        $formData = new AlquilerWizard();
        $flow = $this->get('app.form.flow.crear_alquiler'); // must match the flow's service id
        $flow->bind($formData);

        $form_reserva = $flow->createForm();
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Oferta')->getOfertasByType(3);

        $locale = $request->getLocale();

        $faqs = $em->getRepository('AppBundle:Texto')->getTextoByTipo(1,$locale);
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $faqs, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:default:faqs.html.twig', array(

            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'faqs' => $pagination,
            'form_reserva' => $form_reserva->createView(),
            'results' => $results

        ));
    }

    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }
}
