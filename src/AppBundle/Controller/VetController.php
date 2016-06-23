<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Vet;
use AppBundle\Form\VetType;

/**
 * Vet controller.
 *
 * @Route("/{_locale}/vet", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class VetController extends Controller
{

    /**
     * Lists all Vet entities.
     *
     * @Route("/{_format}", defaults={"_format"="html"}, requirements = { "_format" = "html|xml|atom" }, name="vet")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Vet')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination= $paginator->paginate($entities,$request->query->getInt('page', 1)/*page number*/,5);

        // for the atom feed:
        $lastUpdated = new \DateTime();
        $lastUpdated = $lastUpdated->format(DATE_ATOM);

        return array(
            'pagination' => $pagination,
            'entities' => $entities,
            'lastUpdated' => $lastUpdated,
            'feedId' => sha1($this->get('router')->generate('vet', array('_format'=> 'atom'))),
        );
    }

    /**
     * Creates a new Vet entity.
     *
     * @Route("/new", name="vet_create")
     * @Method("POST")
     * @Template("AppBundle:Vet:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vet_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Vet entity.
     *
     * @param Vet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vet $entity)
    {
        $form = $this->createForm(new VetType(), $entity, array(
            'action' => $this->generateUrl('vet_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vet entity.
     *
     * @Route("/new", name="vet_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vet();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Vet entity.
     *
     * @Route("/{id}", name="vet_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Vet entity.
     *
     * @Route("/{id}/edit", name="vet_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Vet entity.
    *
    * @param Vet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vet $entity)
    {
        $form = $this->createForm(new VetType(), $entity, array(
            'action' => $this->generateUrl('vet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Vet entity.
     *
     * @Route("/{id}", name="vet_update")
     * @Method("PUT")
     * @Template("AppBundle:Vet:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vet_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Vet entity.
     *
     * @Route("/{id}", name="vet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Vet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vet'));
    }

    /**
     * Creates a form to delete a Vet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
