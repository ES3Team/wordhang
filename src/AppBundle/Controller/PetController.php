<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pet;
use AppBundle\Form\PetType;

/**
 * Pet controller.
 *
 * @Route("/{_locale}/pet", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class PetController extends Controller
{

    /**
     * Lists all Pet entities.
     *
     * @Route("/", name="pet")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pet')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination= $paginator->paginate($entities,$request->query->getInt('page', 1)/*page number*/,5);

        return array(
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new Pet entity.
     *
     * @Route("/", name="pet_create")
     * @Method("POST")
     * @Template("AppBundle:Pet:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pet_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pet entity.
     *
     * @param Pet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pet $entity)
    {
        $form = $this->createForm(new PetType(), $entity, array(
            'action' => $this->generateUrl('pet_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pet entity.
     *
     * @Route("/new", name="pet_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pet();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Pet entity.
     *
     * @Route("/new/owner/{id}", name="pet_new4owner")
     * @Method("GET")
     * @Template()
     */
    public function new4OwnerAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityOwner = $em->getRepository('AppBundle:Owner')->find($id);

        if (!$entityOwner) {
            throw $this->createNotFoundException('Unable to find Owner entity.');
        }

        $entity = new Pet();
        $entity->setOwner($entityOwner);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pet entity.
     *
     * @Route("/{id}", name="pet_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pet entity.
     *
     * @Route("/{id}/edit", name="pet_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pet entity.');
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
    * Creates a form to edit a Pet entity.
    *
    * @param Pet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pet $entity)
    {
        $form = $this->createForm(new PetType(), $entity, array(
            'action' => $this->generateUrl('pet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pet entity.
     *
     * @Route("/{id}", name="pet_update")
     * @Method("PUT")
     * @Template("AppBundle:Pet:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pet_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pet entity.
     *
     * @Route("/{id}", name="pet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pet'));
    }

    /**
     * Creates a form to delete a Pet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
