<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Specialty;
use AppBundle\Form\SpecialtyType;

/**
 * Specialty controller.
 *
 * @Route("/{_locale}/specialty", defaults={"_locale"="en"}, requirements = { "_locale" = "en|de" })
 */
class SpecialtyController extends Controller
{

    /**
     * Lists all Specialty entities.
     *
     * @Route("/", name="specialty")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities= $em->getRepository('AppBundle:Specialty')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination= $paginator->paginate($entities,$request->query->getInt('page', 1)/*page number*/,5);

        return array(
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new Specialty entity.
     *
     * @Route("/", name="specialty_create")
     * @Method("POST")
     * @Template("AppBundle:Specialty:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Specialty();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('specialty_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Specialty entity.
     *
     * @param Specialty $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Specialty $entity)
    {
        $form = $this->createForm(new SpecialtyType(), $entity, array(
            'action' => $this->generateUrl('specialty_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Specialty entity.
     *
     * @Route("/new", name="specialty_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Specialty();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Specialty entity.
     *
     * @Route("/{id}", name="specialty_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Specialty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specialty entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Specialty entity.
     *
     * @Route("/{id}/edit", name="specialty_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Specialty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specialty entity.');
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
    * Creates a form to edit a Specialty entity.
    *
    * @param Specialty $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Specialty $entity)
    {
        $form = $this->createForm(new SpecialtyType(), $entity, array(
            'action' => $this->generateUrl('specialty_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Specialty entity.
     *
     * @Route("/{id}", name="specialty_update")
     * @Method("PUT")
     * @Template("AppBundle:Specialty:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Specialty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specialty entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('specialty_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Specialty entity.
     *
     * @Route("/{id}", name="specialty_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Specialty')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Specialty entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('specialty'));
    }

    /**
     * Creates a form to delete a Specialty entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialty_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
