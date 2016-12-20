<?php

namespace Intraway\AvatarBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiRestController extends FOSRestController {

    public function indexAction($id) {
//        return $this->render('IntrawayAvatarBundle:Default:index.html.twig');
        $view = View::create();
        $view->setData(array("id" => $id, "nombre" => "cristian"));
        return $this->handleView($view);
    }

    public function uploadAction(Request $request) {
        $file = $request->files->get('uploadFiles');
        $imgLashes = addslashes($file);
        $imgFileContents = file_get_contents($imgLashes);
        $imgEncode = base64_encode($imgFileContents);

        $view = View::create();
        $view->setData(array(
            "nombre" => "cristian"));
        return $this->handleView($view);
    }
    
    private function safeImg(){
        
    }

}
