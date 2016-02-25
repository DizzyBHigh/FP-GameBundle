<?php

namespace FantasyPro\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FantasyPro\GameBundle\Entity\ContestStyle;
use FantasyPro\GameBundle\Form\ContestStyleType;

/**
 * ContestStyle controller.
 *
 * @Route("/admin/ContestStyle")
 */
class ContestStyleController extends Controller
{

    /**
     * Lists all ContestStyle entities.
     *
     * @Route("/", name="admin_ContestStyle")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'GameBundle:ContestStyle' )->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ContestStyle entity.
     *
     * @Route("/", name="admin_ContestStyle_create")
     * @Method("POST")
     * @Template("GameBundle:ContestStyle:new.html.twig")
     */
    public function createAction( Request $request )
    {
        $entity = new ContestStyle();
        $form   = $this->createCreateForm( $entity );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();

            return $this->redirect( $this->generateUrl( 'admin_ContestStyle', array( 'id' => $entity->getId() ) ) );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ContestStyle entity.
     *
     * @param ContestStyle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( ContestStyle $entity )
    {
        $form = $this->createForm(
            new ContestStyleType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'admin_ContestStyle_create' ),
                'method' => 'POST',
            )
        );

        $form->add(
            'submit',
            'submit',
            array( 'label' => 'Create', 'attr' => array( 'class' => 'btn-sm btn-primary' ) )
        );

        return $form;
    }

    /**
     * Displays a form to create a new ContestStyle entity.
     *
     * @Route("/new", name="admin_ContestStyle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContestStyle();
        $form   = $this->createCreateForm( $entity );

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ContestStyle entity.
     *
     * @Route("/{id}", name="admin_ContestStyle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:ContestStyle' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find ContestStyle entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ContestStyle entity.
     *
     * @Route("/{id}/edit", name="admin_ContestStyle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:ContestStyle' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find ContestStyle entity.' );
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
     * Creates a form to edit a ContestStyle entity.
     *
     * @param ContestStyle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( ContestStyle $entity )
    {
        $form = $this->createForm(
            new ContestStyleType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'admin_ContestStyle_update', array( 'id' => $entity->getId() ) ),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array( 'label' => 'Update', 'attr' => array( 'class' => 'btn-sm btn-primary' ) )
        );

        return $form;
    }

    /**
     * Edits an existing ContestStyle entity.
     *
     * @Route("/{id}", name="admin_ContestStyle_update")
     * @Method("PUT")
     * @Template("GameBundle:ContestStyle:edit.html.twig")
     */
    public function updateAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:ContestStyle' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find ContestStyle entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm   = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect( $this->generateUrl( 'admin_ContestStyle', array( 'id' => $id ) ) );
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ContestStyle entity.
     *
     * @Route("/{id}", name="admin_ContestStyle_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id )
    {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'GameBundle:ContestStyle' )->find( $id );

            if ( ! $entity) {
                throw $this->createNotFoundException( 'Unable to find ContestStyle entity.' );
            }

            $em->remove( $entity );
            $em->flush();
        }

        return $this->redirect( $this->generateUrl( 'admin_ContestStyle' ) );
    }

    /**
     * Creates a form to delete a ContestStyle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id )
    {
        return $this->createFormBuilder()
                    ->setAction( $this->generateUrl( 'admin_ContestStyle_delete', array( 'id' => $id ) ) )
                    ->setMethod( 'DELETE' )
                    ->add(
                        'submit',
                        'submit',
                        array( 'label' => 'Delete', 'attr' => array( 'class' => 'btn-sm btn-primary' ) )
                    )
                    ->getForm();
    }
}
