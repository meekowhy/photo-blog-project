<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Entity\Gallery;
use AppBundle\Form\GalleryType;
use AppBundle\Form\PhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galleries = $em->getRepository('AppBundle:Gallery')->findAll();

        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', [
            'galleries' => $galleries
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


//    /**
//     * @Route ("/upload/")
//     */
//    public function uploadAction(Request $request)
//    {
//
//        $photo = new Photo();
//        $form = $this->createForm(PhotoType::class, $photo);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($photo);
//            $em->flush();
//            return new Response('ok');
//        }
//
//        return $this->render('AppBundle:default:upload.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }

//    /**
//     * @Route ("/gallery/new/")
//     */
//    public function createGalleryAction(Request $request) {
//        $gallery = new Gallery();
//        $form = $this->createForm(GalleryType::class, $gallery);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($gallery);
//            $em->flush();
//            return new Response('ok');
//        }
//
//        return $this->render('AppBundle:default:create_gallery.html.twig', array(
//            'form' => $form->createView()
//        ));
//    }

//    protected function makeForm() {
//
//        $form = $this->createFormBuilder(new Photo());
//        $form
//            ->setMethod('POST')
//            ->add('imageFile', FileType::class, array('label' => 'photo (img file)'))
//            ->add('save',SubmitType::class,['label'=>'save photo']);
//
//        return $form->getForm();
//    }



}
