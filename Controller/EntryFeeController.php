<?php

namespace FantasyPro\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FantasyPro\GameBundle\Entity\EntryFee;
use FantasyPro\GameBundle\Form\EntryFeeType;

/**
 * EntryFee controller.
 *
 * @Route("/admin/EntryFee")
 */
class EntryFeeController extends Controller
{

    /**
     * Lists all EntryFee entities.
     *
     * @Route("/", name="entryfee")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'GameBundle:EntryFee' )->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new EntryFee entity.
     *
     * @Route("/", name="entryfee_create")
     * @Method("POST")
     * @Template("GameBundle:EntryFee:new.html.twig")
     */
    public function createAction( Request $request )
    {
        $entity = new EntryFee();
        $form   = $this->createCreateForm( $entity );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();

            return $this->redirect( $this->generateUrl( 'entryfee', array( 'id' => $entity->getId() ) ) );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a EntryFee entity.
     *
     * @param EntryFee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( EntryFee $entity )
    {
        $form = $this->createForm(
            new EntryFeeType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'entryfee_create' ),
                'method' => 'POST',
            )
        );

        $form->add( 'submit', 'submit', array( 'label' => 'Create' ) );

        return $form;
    }

    /**
     * Displays a form to create a new EntryFee entity.
     *
     * @Route("/new", name="entryfee_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EntryFee();
        $form   = $this->createCreateForm( $entity );

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EntryFee entity.
     *
     * @Route("/{id}", name="entryfee_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:EntryFee' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find EntryFee entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EntryFee entity.
     *
     * @Route("/{id}/edit", name="entryfee_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:EntryFee' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find EntryFee entity.' );
        }

        $editForm   = $this->createEditForm( $entity );
        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a EntryFee entity.
     *
     * @param EntryFee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( EntryFee $entity )
    {
        $form = $this->createForm(
            new EntryFeeType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'entryfee_update', array( 'id' => $entity->getId() ) ),
                'method' => 'PUT',
            )
        );

        $form->add( 'submit', 'submit', array( 'label' => 'Update' ) );

        return $form;
    }

    /**
     * Edits an existing EntryFee entity.
     *
     * @Route("/{id}", name="entryfee_update")
     * @Method("PUT")
     * @Template("GameBundle:EntryFee:edit.html.twig")
     */
    public function updateAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:EntryFee' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find EntryFee entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm   = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect( $this->generateUrl( 'entryfee_edit', array( 'id' => $id ) ) );
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EntryFee entity.
     *
     * @Route("/{id}", name="entryfee_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id )
    {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'GameBundle:EntryFee' )->find( $id );

            if ( ! $entity) {
                throw $this->createNotFoundException( 'Unable to find EntryFee entity.' );
            }

            $em->remove( $entity );
            $em->flush();
        }

        return $this->redirect( $this->generateUrl( 'entryfee' ) );
    }

    /**
     * Creates a form to delete a EntryFee entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id )
    {
        return $this->createFormBuilder()
                    ->setAction( $this->generateUrl( 'entryfee_delete', array( 'id' => $id ) ) )
                    ->setMethod( 'DELETE' )
                    ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
                    ->getForm();
    }
}
