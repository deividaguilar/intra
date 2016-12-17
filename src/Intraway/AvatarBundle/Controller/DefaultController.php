<?php

namespace Intraway\AvatarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IntrawayAvatarBundle:Default:index.html.twig');
    }
}
