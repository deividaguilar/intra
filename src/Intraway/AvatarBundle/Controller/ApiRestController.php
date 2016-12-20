<?php

namespace Intraway\AvatarBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Intraway\AvatarBundle\Entity\Avatars;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiRestController extends FOSRestController {

    private $imgEncode;
    private $imgName;
    private $imgMimeType;
    private $imgSize;
    private $imgExten;

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
        $this->setImgEncode(base64_encode($imgFileContents));
        $this->setImgMimeType($file->getMimeType());
        $this->setImgName($file->getClientOriginalName());
        $this->setImgSize($file->getClientSize());
        $this->setImgExten($file->getClientOriginalExtension());

        $view = View::create();
        $view->setData(array(
            "message" => $this->validateImg()));
        return $this->handleView($view);
    }

    private function validateImg() {
        if (empty($this->searchImg($this->getImgEncode()))) {
            $salida = $this->safeImg();
        } else {
            $salida = "This image already exist in the db";
        }
        return $salida;
    }

    private function safeImg() {
        $avatar = new Avatars();
        $avatar->setExtension($this->getImgExten());
        $avatar->setImage($this->getImgEncode());
        $avatar->setMimetype($this->getImgMimeType());
        $avatar->setSize(100);
        $avatar->setSizefile($this->getImgSize());
        $avatar->setName($this->getImgName());
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($avatar);
            $em->flush();
        } catch (Exception $ex) {
            return "Error saved image";
        }
        return "Image saved correctly";
    }

    private function searchImg($image) {
        $row = $this->getDoctrine()
                ->getRepository("IntrawayAvatarBundle:Avatars")
                ->findBy(array('image' => $image));
        return empty($row) ? NULL : $row[0];
    }

    private function getImgEncode() {
        return $this->imgEncode;
    }

    private function setImgEncode($imgEncode) {
        $this->imgEncode = $imgEncode;
    }

    private function getImgName() {
        return $this->imgName;
    }

    private function setImgName($name) {
        $this->imgName = $name;
    }

    private function getImgMimeType() {
        return $this->imgMimeType;
    }

    private function setImgMimeType($mimeType) {
        $this->imgMimeType = $mimeType;
    }

    private function getImgSize() {
        return $this->imgSize;
    }

    private function setImgSize($size) {
        $this->imgSize = $size;
    }

    private function getImgExten() {
        return $this->imgExten;
    }

    private function setImgExten($exten) {
        $this->imgExten = $exten;
    }

}
