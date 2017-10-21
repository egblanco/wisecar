<?php

namespace abd\UserBundle\Controller;

use abd\BlogBundle\Entity\Post;
use abd\BlogBundle\Form\PostEditType;
use abd\BlogBundle\Form\PostType;
use AppBundle\Entity\Alquiler;
use AppBundle\Entity\AlquilerArticulo;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\OfertaAuto;
use AppBundle\Entity\Texto;
use AppBundle\Exception\CustomForbiddenActionException;
use AppBundle\Form\AlquilerType;
use AppBundle\Form\OfertaAddType;
use AppBundle\Form\OfertaType;
use AppBundle\Form\TextoType;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use JavierEguiluz\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use Symfony\Component\HttpFoundation\Request;
use abd\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends BaseAdminController
{
    protected function initialize(Request $request)
    {
        $this->get('translator')->setLocale('es');
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', 'es');
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', 'es'));
        }
        parent::initialize($request);
    }

    /**
     * The method that is executed when the user performs a 'edit' action on an entity.
     *
     * @return RedirectResponse|Response
     */
    protected function editAction()
    {
        try{
            return parent::editAction();
        }catch(CustomForbiddenActionException $e){

            $session = $this->request->getSession();
            $session->getFlashBag()->add('error', $e->getMessage());
            $refererUrl = $this->request->query->get('referer', '');

            return  !empty($refererUrl)
                ? $this->redirect(urldecode($refererUrl))
                : $this->redirect($this->generateUrl('easyadmin', array('action' => 'list', 'entity' => $this->entity['name'])));
        }
    }

    protected function deleteAction()
    {
        try{
            return parent::deleteAction();
        }catch(CustomForbiddenActionException $e){

            $session = $this->request->getSession();
            $session->getFlashBag()->add('error', $e->getMessage());
            $refererUrl = $this->request->query->get('referer', '');

            return  !empty($refererUrl)
                ? $this->redirect(urldecode($refererUrl))
                : $this->redirect($this->generateUrl('easyadmin', array('action' => 'list', 'entity' => $this->entity['name'])));
        }
    }

    public function createNewUsuariosEntity()
    {
        return $this->container->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUsuariosEntity(User $user)
    {
        $this->container->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateUsuariosEntity(User $user)
    {
        if($user->getUsername() == 'admin' && !($user->hasRole('ROLE_ADMIN') && $user->isEnabled())){
            throw new CustomForbiddenActionException('Se ha intentado ejecutar una acción no permitida sobre el usuario \'admin\'.');
        }
        $this->container->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preRemoveUsuariosEntity(User $user)
    {
        //denegar la eliminacion del usuario admin.
        if($user->getUsername() == 'admin'){
            throw new CustomForbiddenActionException('Imposible eliminar el usuario \'admin\'.');
        }
    }

    /*public function createAlquilerNewForm(Alquiler $entity)
    {
        $alquilerType = new AlquilerType();
        $alquilerType->setEm($this->getDoctrine()->getManager());
        $alquilerType->setEntity($entity);
        $form = $this->createForm($alquilerType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function createAlquilerEditForm(Alquiler $entity)
    {
        $alquilerType = new AlquilerType();
        $alquilerType->setEm($this->getDoctrine()->getManager());
        $alquilerType->setEntity($entity);
        $form = $this->createForm($alquilerType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function prePersistAlquilerEntity(Alquiler $alquiler)
    {
        $em = $this->getDoctrine()->getManager();
        $idAuto =  $this->request->get('appbundle_alquiler')['auto'];
        $idArticulos = array();

        $fields = $this->request->get('appbundle_alquiler');
        if(array_key_exists('accesorios', $fields)){
            $idAccesorios =  $this->request->get('appbundle_alquiler')['accesorios'];
            $idArticulos = array_merge((array)$idAuto, (array)$idAccesorios);
        }else{
            $idArticulos[] = $idAuto;
        }
        if(array_key_exists('seguro', $fields)){
            $idSeguro =  $this->request->get('appbundle_alquiler')['seguro'];
            $idArticulos = array_merge((array)$idArticulos,(array)$idSeguro);
        }
        $articulos = $em->getRepository('AppBundle:Articulo')->getIdIn($idArticulos);

        foreach($articulos as $articulo){
            $alquilerArticulo = new AlquilerArticulo();
            $alquilerArticulo->setAlquiler($alquiler);
            $alquilerArticulo->setArticulo($articulo);
            $alquiler->addAlquilerArticulo($alquilerArticulo);
            $em->persist($alquilerArticulo);
        }
    }

    public function preUpdateAlquilerEntity(Alquiler $alquiler)
    {
        $em = $this->getDoctrine()->getManager();
        $idAuto =  $this->request->get('appbundle_alquiler')['auto'];
        $alquilerDb = $em->getRepository('AppBundle:Alquiler')->getAuto($alquiler->getId());
        $alquilerArticulo = $alquilerDb->getAlquilerArticulos()[0];
        if($alquilerArticulo->getArticulo()->getId() != (int)$idAuto){
            $auto = $em->getRepository('AppBundle:Auto')->find($idAuto);
            $alquilerArticulo->setArticulo($auto);
            $alquilerArticulo->setAlquiler($alquiler);
            $em->persist($alquilerArticulo);
        }
    }*/

    public function createRatesListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 1");

        return $queryBuilder;
    }

    public function createRatesNewForm(Oferta $entity)
    {
        $ofertaType = new OfertaType();
        $em = $this->getDoctrine()->getManager();
        $autos = $em->getRepository('AppBundle:Auto')->findAll();
        $temporadaTipo = $em->getRepository('AppBundle:OfertaTipo')->find(1);
        $entity->setTipo($temporadaTipo);
        foreach($autos as $auto){
            $ofertaAuto = new OfertaAuto();
            $ofertaAuto->setAuto($auto);
            $ofertaAuto->setOferta($entity);
            $entity->addOfertaAuto($ofertaAuto);
        }

        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function createRatesEditForm(Oferta $entity)
    {
        $ofertaType = new OfertaType();
        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function createWiseDealsListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 2");

        return $queryBuilder;
    }

    public function createWiseDealsNewForm(Oferta $entity)
    {
        $ofertaType = new OfertaAddType();
        $em = $this->getDoctrine()->getManager();
        $temporadaTipo = $em->getRepository('AppBundle:OfertaTipo')->find(2);
        $entity->setTipo($temporadaTipo);
        $ofertaAuto = new OfertaAuto();
        $ofertaAuto->setOferta($entity);
        $entity->addOfertaAuto($ofertaAuto);
        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function createWiseDealsEditForm(Oferta $entity)
    {
        $ofertaType = new OfertaAddType();
        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function preUpdateWiseDealsEntity(Oferta $oferta){
        $em = $this->getDoctrine()->getManager();
        $ofertaAutoDb = $em->getRepository('AppBundle:OfertaAuto')->getAllByOferta($oferta->getId());
        foreach($ofertaAutoDb as $ofertaAutoDb){
            $found = false;
            foreach($oferta->getOfertaAutos() as $ofertaAuto){
                if($ofertaAuto->getId() == $ofertaAutoDb->getId()){
                    $found = true;
                    break;
                }
            }
            if(!$found){
                $em->remove($ofertaAutoDb);
            }
        }
    }

    public function createLastMinutesListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 3");

        return $queryBuilder;
    }

    public function createLastMinutesNewForm(Oferta $entity)
    {
        $ofertaType = new OfertaType();
        $em = $this->getDoctrine()->getManager();
        $temporadaTipo = $em->getRepository('AppBundle:OfertaTipo')->find(3);
        $entity->setTipo($temporadaTipo);
        $ofertaAuto = new OfertaAuto();
        $ofertaAuto->setOferta($entity);
        $entity->addOfertaAuto($ofertaAuto);
        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function createLastMinutesEditForm(Oferta $entity)
    {
        $ofertaType = new OfertaType();
        $form = $this->createForm($ofertaType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    public function prePersistAutosEntity(Auto $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $rates = $em->getRepository('AppBundle:Oferta')->getOfertaByTipo(1);
        foreach($rates as $rate){
            $ofertaAuto = new OfertaAuto();
            $ofertaAuto->setAuto($entity);
            $ofertaAuto->setOferta($rate);
            $ofertaAuto->setPrecio($entity->getPrecio());
            $ofertaAuto->setSemanal($entity->getPrecio() * 7);
            $entity->addOfertaAuto($ofertaAuto);
        }
    }

    public function createContactoListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 1");

        return $queryBuilder;
    }

    public function createComentariosListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 2");

        return $queryBuilder;
    }

    public function createEntradasNewForm(Post $entity)
    {
        $postType = new PostType();
        $form = $this->createForm($postType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function createEntradasEditForm(Post $entity)
    {
        $postType = new PostEditType();
        $form = $this->createForm($postType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function createFAQListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 1");

        return $queryBuilder;
    }

    public function createFAQNewForm(Texto $entity)
    {
        $textoType = new TextoType();
        $form = $this->createForm($textoType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function createFAQEditForm(Texto $entity)
    {
        $textoType = new TextoType();
        $form = $this->createForm($textoType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function prePersistFAQEntity(Texto $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository('AppBundle:TextoTipo')->find(1);
        $entity->setTipo($tipo);
    }

    public function createTipListQueryBuilder($entityClass, $sortDirection, $sortField = null){

        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField = null);

        $queryBuilder->innerJoin('entity.tipo','tipo')->where("tipo.id = 2");

        return $queryBuilder;
    }

    public function createTipNewForm(Texto $entity)
    {
        $textoType = new TextoType();
        $form = $this->createForm($textoType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function createTipEditForm(Texto $entity)
    {
        $textoType = new TextoType();
        $form = $this->createForm($textoType, $entity, array());
        $form->add('submit', 'submit', array('label' => 'Guardar Cambios'));
        return $form;
    }

    public function prePersistTipEntity(Texto $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository('AppBundle:TextoTipo')->find(2);
        $entity->setTipo($tipo);
    }

}