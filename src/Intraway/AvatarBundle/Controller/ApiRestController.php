<?php

namespace Intraway\AvatarBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Intraway\AvatarBundle\Entity\Avatars;
use Intraway\AvatarBundle\Entity\Emails;
use Symfony\Component\Filesystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiRestController extends FOSRestController {

    private $imgEncode;
    private $imgName;
    private $imgMimeType;
    private $imgSize;
    private $imgExten;
    private $imgThumb;
    private $request;

    public function indexAction($opt, Request $request) {

//        return $this->render('IntrawayAvatarBundle:Default:index.html.twig');
        $this->setRequest($request);
        $view = View::create();
        $view->setData($this->selectOption($opt));
        return $this->handleView($view);
    }

    private function selectOption($opt) {
        switch ($opt) {
            case 1:
                $data = $this->showAvatares();
                break;
            case 2 :
                $data = $this->searchAvatar();
                break;
            case 3 :
                $data = $this->saveData();
                break;
        }
        return $data;
    }

    private function searchAvatar() {

        $email = $this->getDoctrine()
                        ->getRepository("IntrawayAvatarBundle:Emails")->find($this->getRequest()->get('email'));

        if (empty($email)) {
            return array("message" => "Data not found. You can save your data!!!", "img" => $this->imgDefault()->getId());
        } else {
            return array("message" => "Data found", "img" => $email->getIdavatar()->getId());
        }
//        return $this->insertEmail($avatar, $this->getRequest()->get('email'), $email);
    }

    private function saveData() {
        $email = $this->getDoctrine()
                        ->getRepository("IntrawayAvatarBundle:Emails")->find($this->getRequest()->get('email'));
        $avatar = $this->getDoctrine()
                        ->getRepository("IntrawayAvatarBundle:Avatars")->find($this->getRequest()->get('idAvatar'));

        if (empty($email)) {
            $emailIn = '';
            $email = new Emails();
            $email->setHashmd5($this->getRequest()->get('email'));
        }

        $finalAvatar = empty($avatar) ? $this->imgDefault() : $avatar;
        $email->setIdavatar($finalAvatar);
        try {
            $em = $this->getDoctrine()->getManager();
            if (empty($emailIn)) {
                $em->persist($email);
            }
            $em->flush();
        } catch (Exception $ex) {
            return array("message" => "Error saved image", "img" => $this->imgDefault()->getId());
        }
        return array("message" => "Image saved correctly", "img" => $finalAvatar->getId());
    }

    private function imgDefault() {
        $avatar = $this->getDoctrine()
                        ->getRepository("IntrawayAvatarBundle:Avatars")->findBy(array("name" => 'empty.jpg'));
        return $avatar[0];
    }

    private function showAvatares() {
        $rows = $this->getDoctrine()
                ->getRepository("IntrawayAvatarBundle:Avatars")
                ->findAll();
        return empty($rows) ? NULL : $this->createObjAvatar($rows);
    }

    private function createObjAvatar($rows) {
        $salida = array();
        foreach ($rows as $arrAvatar) {
            $avatar = [];
            $avatar['image'] = stream_get_contents($arrAvatar->getImage());
            $avatar['mimetype'] = $arrAvatar->getMimetype();
            $avatar['size'] = $arrAvatar->getSize();
            $avatar['sizefile'] = $arrAvatar->getSizefile();
            $avatar['extension'] = $arrAvatar->getExtension();
            $avatar['thumb'] = stream_get_contents($arrAvatar->getThumb());
            $avatar['name'] = $arrAvatar->getName();
            $salida[$arrAvatar->getId()] = $avatar;
        }
        return $salida;
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
        $this->setImgThumb($this->createThumImg($file));

        $view = View::create();
        $view->setData(array(
            "message" => $this->validateImg()));
        return $this->handleView($view);
    }

    private function createThumImg($file) {

        $percent = 0.5;
        list($width, $height) = getimagesize($file);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;


// Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);

        $source = imagecreatefromstring(base64_decode($this->getImgEncode()));

// Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $this->getImgName());
        $ds = DIRECTORY_SEPARATOR;

        $tmpFile = str_replace("src{$ds}Intraway{$ds}AvatarBundle{$ds}Controller", "web" . $ds . $this->getImgName(), __DIR__);

        $fs = new Filesystem();


        $imgFileContents = file_get_contents($tmpFile);
        $fs->remove($tmpFile);
        return base64_encode($imgFileContents);
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
        $avatar->setThumb($this->getImgThumb());
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

    private function getImgThumb() {
        return $this->imgThumb;
    }

    private function setImgThumb($thumb) {
        $this->imgThumb = $thumb;
    }

    private function getRequest() {
        return $this->request;
    }

    private function setRequest($request) {
        $this->request = $request;
    }

}
