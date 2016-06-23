<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PetType;
use AppBundle\Form\PetTypeType;

/**
 * PetType controller.
 *
 * @Route("/{_locale}/pettype", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class PetTypeController extends Controller
{

    /**
     * Lists all PetType entities.
     *
     * @Route("/", name="pettype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:PetType')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination= $paginator->paginate($entities,$request->query->getInt('page', 1)/*page number*/,5);

        return array(
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new PetType entity.
     *
     * @Route("/", name="pettype_create")
     * @Method("POST")
     * @Template("AppBundle:PetType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PetType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pettype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PetType entity.
     *
     * @param PetType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PetType $entity)
    {
        $form = $this->createForm(new PetTypeType(), $entity, array(
            'action' => $this->generateUrl('pettype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PetType entity.
     *
     * @Route("/new", name="pettype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PetType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PetType entity.
     *
     * @Route("/{id}", name="pettype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PetType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PetType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PetType entity.
     *
     * @Route("/{id}/edit", name="pettype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PetType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PetType entity.');
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
    * Creates a form to edit a PetType entity.
    *
    * @param PetType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PetType $entity)
    {
        $form = $this->createForm(new PetTypeType(), $entity, array(
            'action' => $this->generateUrl('pettype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PetType entity.
     *
     * @Route("/{id}", name="pettype_update")
     * @Method("PUT")
     * @Template("AppBundle:PetType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PetType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PetType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pettype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PetType entity.
     *
     * @Route("/{id}", name="pettype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:PetType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PetType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pettype'));
    }

    /**
     * Creates a form to delete a PetType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pettype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
