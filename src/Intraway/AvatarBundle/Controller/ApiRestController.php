<?php

namespace Intraway\AvatarBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiRestController extends FOSRestController {

    public function indexAction($id) {
//        return $this->render('IntrawayAvatarBundle:Default:index.html.twig');
        $view = View::create();
        $view->setData(array("id" => $id, "nombre" => "cristian"));
        return $this->handleView($view);
    }

}
