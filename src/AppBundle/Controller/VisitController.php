<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Visit;
use AppBundle\Form\VisitType;

/**
 * Visit controller.
 *
 * @Route("/{_locale}/visit", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class VisitController extends Controller
{

    /**
     * Lists all Visit entities.
     *
     * @Route("/", name="visit")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Visit')->findAll();

        return array(
            'entities' => $entities,
        );

        $paginator  = $this->get('knp_paginator');
        $pagination= $paginator->paginate($entities,$request->query->getInt('page', 1)/*page number*/,5);

        return array(
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new Visit entity.
     *
     * @Route("/", name="visit_create")
     * @Method("POST")
     * @Template("AppBundle:Visit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Visit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('visit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Visit entity.
     *
     * @param Visit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Visit $entity)
    {
        $form = $this->createForm(new VisitType(), $entity, array(
            'action' => $this->generateUrl('visit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Visit entity.
     *
     * @Route("/new", name="visit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Visit();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Visit entity.
     *
     * @Route("/new/pet/{id}", name="visit_new4pet")
     * @Method("GET")
     * @Template()
     */
    public function newForPetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityPet = $em->getRepository('AppBundle:Pet')->find($id);

        if (!$entityPet) {
            throw $this->createNotFoundException('Unable to find Pet entity.');
        }

        $entity = new Visit();
        $entity->setPet($entityPet);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Visit entity.
     *
     * @Route("/{id}", name="visit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Visit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Visit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Visit entity.
     *
     * @Route("/{id}/edit", name="visit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Visit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Visit entity.');
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
    * Creates a form to edit a Visit entity.
    *
    * @param Visit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Visit $entity)
    {
        $form = $this->createForm(new VisitType(), $entity, array(
            'action' => $this->generateUrl('visit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Visit entity.
     *
     * @Route("/{id}", name="visit_update")
     * @Method("PUT")
     * @Template("AppBundle:Visit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Visit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Visit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('visit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Visit entity.
     *
     * @Route("/{id}", name="visit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Visit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Visit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('visit'));
    }

    /**
     * Creates a form to delete a Visit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
