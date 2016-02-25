<?php

namespace FantasyPro\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FantasyPro\GameBundle\Entity\ScheduleGroup;

/**
 * ScheduleGroup controller.
 *
 * @Route("/admin/ScheduleGroup")
 */
class ScheduleGroupController extends Controller
{

    /**
     * Lists all ScheduleGroup scheduleGroups.
     *
     * @Route("/", name="schedulegroup")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleGroups = $em->getRepository( 'GameBundle:ScheduleGroup' )->findAll();

        return array(
            'schedulegroups' => $scheduleGroups,
        );
    }

    /**
     * Creates a new ScheduleGroup entity.
     *
     * @Route("/", name="schedulegroup_create")
     * @Method("POST")
     * @Template("GameBundle:ScheduleGroup:new.html.twig")
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction( Request $request )
    {
        $scheduleGroups = new ScheduleGroup();
        $form           = $this->createCreateForm( $scheduleGroups );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $scheduleGroups );
            $em->flush();

            return $this->redirect( $this->generateUrl( 'schedulegroup' ) );
        }

        return array(
            'entity' => $scheduleGroups,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ScheduleGroup entity.
     *
     * @param ScheduleGroup $scheduleGroups The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm( ScheduleGroup $scheduleGroups )
    {
        $form = $this->createForm(
            'schedulegroups',
            $scheduleGroups,
            array(
                'action' => $this->generateUrl( 'schedulegroup_create' ),
                'method' => 'POST',
            )
        );

        $form->add( 'submit', 'submit', array( 'label' => 'Create' ) );

        return $form;
    }

    /**
     * Displays a form to create a new ScheduleGroup entity.
     *
     * @Route("/new", name="schedulegroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $scheduleGroup = new ScheduleGroup();
        $form          = $this->createCreateForm( $scheduleGroup );

        return array(
            'entity' => $scheduleGroup,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ScheduleGroup entity.
     *
     * @Route("/{id}", name="schedulegroup_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleGroups = $em->getRepository( 'GameBundle:ScheduleGroup' )->find( $id );

        if ( ! $scheduleGroups) {
            throw $this->createNotFoundException( 'Unable to find ScheduleGroup entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $scheduleGroups,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ScheduleGroup entity.
     *
     * @Route("/{id}/edit", name="schedulegroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleGroups = $em->getRepository( 'GameBundle:ScheduleGroup' )->find( $id );

        if ( ! $scheduleGroups) {
            throw $this->createNotFoundException( 'Unable to find ScheduleGroup entity.' );
        }

        $editForm   = $this->createEditForm( $scheduleGroups );
        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $scheduleGroups,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a ScheduleGroup entity.
     *
     * @param ScheduleGroup $scheduleGroup The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm( ScheduleGroup $scheduleGroup )
    {
        $form = $this->createForm(
            'schedulegroups',
            $scheduleGroup,
            array(
                'action' => $this->generateUrl( 'schedulegroup_update', array( 'id' => $scheduleGroup->getId() ) ),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Update',
                'attr'  => array(
                    'class' => 'btn-sm button-primary'
                )
            )
        );

        return $form;
    }

    /**
     * Edits an existing ScheduleGroup entity.
     *
     * @Route("/{id}", name="schedulegroup_update")
     * @Method("PUT")
     * @Template("GameBundle:ScheduleGroup:edit.html.twig")
     */
    public function updateAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleGroups = $em->getRepository( 'GameBundle:ScheduleGroup' )->find( $id );

        if ( ! $scheduleGroups) {
            throw $this->createNotFoundException( 'Unable to find ScheduleGroup entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm   = $this->createEditForm( $scheduleGroups );
        $editForm->handleRequest( $request );

        if ($editForm->isValid()) {
            //$em->persist($scheduleGroups);
            //$em->flush();

            return $this->redirect( $this->generateUrl( 'schedulegroup', array( 'id' => $id ) ) );
        }

        return array(
            'entity'      => $scheduleGroups,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ScheduleGroup entity.
     *
     * @Route("/{id}", name="schedulegroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction( Request $request, $id )
    {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em             = $this->getDoctrine()->getManager();
            $scheduleGroups = $em->getRepository( 'GameBundle:ScheduleGroup' )->find( $id );

            if ( ! $scheduleGroups) {
                throw $this->createNotFoundException( 'Unable to find ScheduleGroup entity.' );
            }

            $em->remove( $scheduleGroups );
            $em->flush();
        }

        return $this->redirect( $this->generateUrl( 'schedulegroup' ) );
    }

    /**
     * Creates a form to delete a ScheduleGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm( $id )
    {
        return $this->createFormBuilder()
                    ->setAction( $this->generateUrl( 'schedulegroup_delete', array( 'id' => $id ) ) )
                    ->setMethod( 'DELETE' )
                    ->add(
                        'submit',
                        'submit',
                        array(
                            'label' => 'Delete',
                            'attr'  => array(
                                'class' => 'btn-sm btn-warning'
                            )
                        )
                    )
                    ->getForm();
    }
}
