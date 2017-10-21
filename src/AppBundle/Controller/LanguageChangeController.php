<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Language controller.
 *
 * @Route("/language")
 */
class LanguageChangeController extends Controller {

    /**
     * Finds and displays a Account entity.
     *
     * @Route("/{language}", name="change_language")
     * @Method("GET")
     * @Template()
     */
    public function changeAction($language) {
        $request = $this->getRequest();
        $request->setLocale($language);

        $referer = $request->headers->get('referer');
        $router = $this->get('router');

        // Create URL path to pass it to matcher
        $urlParts = parse_url($referer);
        $basePath = $request->getBaseUrl();
        $path = str_replace($basePath, '', $urlParts['path']);
        if ($path == '') {
            $path = '/';
        }
        // Match route and get it's arguments
        $route = $router->match($path);
        $routeAttrs = array_replace($route, array('_locale' => $language));
        $routeName = $routeAttrs['_route'];
        unset($routeAttrs['_route']);


        return new RedirectResponse($router->generate($routeName, $routeAttrs));
    }
}
