<?php

namespace FantasyPro\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FantasyPro\GameBundle\Entity\PayoutStructure;
use FantasyPro\GameBundle\Form\PayoutStructureType;

/**
 * PayoutStructure controller.
 *
 * @Route("/admin/PayoutStructure")
 */
class PayoutStructureController extends Controller
{

    /**
     * Lists all PayoutStructure entities.
     *
     * @Route("/", name="admin_PayoutStructure")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'GameBundle:PayoutStructure' )->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new PayoutStructure entity.
     *
     * @Route("/", name="admin_PayoutStructure_create")
     * @Method("POST")
     * @Template("GameBundle:PayoutStructure:new.html.twig")
     */
    public function createAction( Request $request )
    {
        $entity = new PayoutStructure();
        $form   = $this->createCreateForm( $entity );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();

            return $this->redirect( $this->generateUrl( 'admin_PayoutStructure', array( 'id' => $entity->getId() ) ) );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PayoutStructure entity.
     *
     * @param PayoutStructure $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( PayoutStructure $entity )
    {
        $form = $this->createForm(
            new PayoutStructureType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'admin_PayoutStructure_create' ),
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
     * Displays a form to create a new PayoutStructure entity.
     *
     * @Route("/new", name="admin_PayoutStructure_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PayoutStructure();
        $form   = $this->createCreateForm( $entity );

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PayoutStructure entity.
     *
     * @Route("/{id}", name="admin_PayoutStructure_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:PayoutStructure' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find PayoutStructure entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PayoutStructure entity.
     *
     * @Route("/{id}/edit", name="admin_PayoutStructure_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:PayoutStructure' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find PayoutStructure entity.' );
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
     * Creates a form to edit a PayoutStructure entity.
     *
     * @param PayoutStructure $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( PayoutStructure $entity )
    {
        $form = $this->createForm(
            new PayoutStructureType(),
            $entity,
            array(
                'action' => $this->generateUrl( 'admin_PayoutStructure_update', array( 'id' => $entity->getId() ) ),
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
     * Edits an existing PayoutStructure entity.
     *
     * @Route("/{id}", name="admin_PayoutStructure_update")
     * @Method("PUT")
     * @Template("GameBundle:PayoutStructure:edit.html.twig")
     */
    public function updateAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'GameBundle:PayoutStructure' )->find( $id );

        if ( ! $entity) {
            throw $this->createNotFoundException( 'Unable to find PayoutStructure entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm   = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect( $this->generateUrl( 'admin_PayoutStructure', array( 'id' => $id ) ) );
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PayoutStructure entity.
     *
     * @Route("/{id}", name="admin_PayoutStructure_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id )
    {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'GameBundle:PayoutStructure' )->find( $id );

            if ( ! $entity) {
                throw $this->createNotFoundException( 'Unable to find PayoutStructure entity.' );
            }

            $em->remove( $entity );
            $em->flush();
        }

        return $this->redirect( $this->generateUrl( 'admin_PayoutStructure' ) );
    }

    /**
     * Creates a form to delete a PayoutStructure entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id )
    {
        return $this->createFormBuilder()
                    ->setAction( $this->generateUrl( 'admin_PayoutStructure_delete', array( 'id' => $id ) ) )
                    ->setMethod( 'DELETE' )
                    ->add(
                        'submit',
                        'submit',
                        array( 'label' => 'Delete', 'attr' => array( 'class' => 'btn-sm btn-warning' ) )
                    )
                    ->getForm();
    }
}
