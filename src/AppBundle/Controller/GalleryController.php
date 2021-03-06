<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gallery controller.
 *
 * @Route("gallery")
 */
class GalleryController extends Controller
{
    /**
     * Lists all gallery entities.
     *
     * @Route("/", name="gallery_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galleries = $em->getRepository('AppBundle:Gallery')->findAll();

        return $this->render('AppBundle:gallery:index.html.twig', array(
            'galleries' => $galleries,
        ));
    }

    /**
     * Creates a new gallery entity.

     * @Route("/new", name="gallery_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $gallery = new Gallery();
        $form = $this->createForm('AppBundle\Form\GalleryType', $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();

            return $this->redirectToRoute('gallery_edit', array('id' => $gallery->getId()));
        }

        return $this->render('AppBundle:gallery:new.html.twig', array(
            'gallery' => $gallery,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a gallery entity.
     *
     * @Route("/{id}", name="gallery_show")
     * @Method("GET")
     */
    public function showAction(Gallery $gallery)
    {
//        $deleteForm = $this->createDeleteForm($gallery);

        return $this->render('AppBundle:gallery:show.html.twig', ['gallery'=>$gallery]);
    }

    /**
     * Displays a form to edit an existing gallery entity.
     *
     * @Route("/{id}/edit", name="gallery_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gallery $gallery)
    {

        $photo = (new Photo())->setGallery($gallery);
        $photoForm = $this->createForm('AppBundle\Form\PhotoType', $photo);
        $photoForm->handleRequest($request);

        $deleteForm = $this->createDeleteForm($gallery);

        $editForm = $this->createForm('AppBundle\Form\GalleryType', $gallery);
        $editForm->handleRequest($request);


        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();


            return $this->render('gallery/edit.html.twig', array(
                'gallery' => $gallery,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'photo_form' => $photoForm->createView()
            ));
        }


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_edit', array('id' => $gallery->getId()));
        }

        return $this->render('AppBundle:gallery:edit.html.twig', array(
            'gallery' => $gallery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'photo_form' => $photoForm->createView()
        ));
    }

    /**
     * Deletes a gallery entity.
     *
     * @Route("/{id}", name="gallery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gallery $gallery)
    {
        $form = $this->createDeleteForm($gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photosToDelete = $gallery->getPhotos();

            foreach ($photosToDelete as $photoToDelete) {
                $path = __DIR__ . '/../../../web/img/uploads/' . $photoToDelete->getImageName();
                if (file_exists($path)) {
                    unlink($path);
                }
                $em->remove($photoToDelete);
                $em->flush();
            }
            $em->remove($gallery);


            $em->flush();
        }

        return $this->redirectToRoute('gallery_index');
    }

    /**
     * Creates a form to delete a gallery entity.
     *
     * @param Gallery $gallery The gallery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gallery $gallery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_delete', array('id' => $gallery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
