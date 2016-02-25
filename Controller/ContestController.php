<?php

namespace FantasyPro\GameBundle\Controller;

use FantasyPro\GameBundle\Entity\Contest;
use FantasyPro\GameBundle\Entity\ContestEntry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contest controller.
 * @Route("/contests", name="contests")
 */
class ContestController extends Controller
{
    /**
     * List All Contests.
     *
     * @Route("/", name="list_contests")
     * @Template("GameBundle:Contest:list_contests.html.twig")
     *
     * @return array
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contests = $em->getRepository( 'GameBundle:Contest' )->findAll();

        return array(
            'contests' => $contests,
        );
    }

    /**
     * Shows a Form for Creating a Contest.
     *
     * @Route("/create", name="create_contest")
     * @Template("GameBundle:Forms:create_contest_form.html.twig")
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction( Request $request )
    {
        $contest = new Contest();

        $form = $this->createForm( 'contest', $contest );
        $form->handleRequest( $request );

        if ($form->isValid()) {
            $user = $this->getUser();
            $contest->addUser( $user );

            $em = $this->getDoctrine()->getManager();
            $em->persist( $contest );
            $em->flush();

            $this->addFlash(
                'notice',
                'Contest Created!!'
            );
            $contestID = $contest->getId();

            return $this->redirect(
                $this->generateUrl( 'enter_contest', array( 'id' => $contestID ) )
            );
        }

        return array(
            'contestForm' => $form->createView(),
        );
    }

    /**
     * Lists Contest Entrys for the currently logged in user
     *
     * @Route("/contestentries", name="list_contestentries")
     * @Template("GameBundle:ContestEntry:list.html.twig")
     */
    public function entryListAction()
    {
        $user           = $this->getUser();
        $contestEntries = $this->getDoctrine()->getRepository( 'GameBundle:ContestEntry' )->findAllByUser( $user );

        //ladybug_dump($contestEntries);
        return array(
            'contestEntries' => $contestEntries
        );
    }

    /**
     * Shows a form for Entering a Contest.
     *
     * @Route("/enter/{id}", name="enter_contest")
     * @Template("GameBundle:ContestEntry:new.html.twig")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function enterAction( Request $request )
    {
        $contestHelper = $this->get( 'contest_helper' );
        $contestEntry  = new ContestEntry();

        $em = $this->get( 'doctrine.orm.entity_manager' );
        //get the repos
        $contestRepo = $em->getRepository( 'GameBundle:Contest' );

        $contestID = $request->attributes->get( 'id' );
        $contest   = $contestRepo->find( $contestID );

        $avaliablePlayers = $contestHelper->getPlayersforContestResult( $contest );
        $user             = $this->getUser();
        $contestEntry->setContest( $contest );
        $contestEntry->setUser( $user );
        $contestEntry->setLocked( false );

        $form = $this->createForm( 'contestEntry', $contestEntry );

        $form->handleRequest( $request );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist( $contestEntry );
            $em->flush();
            $this->addFlash(
                'notice',
                'Contest Entry Created!!'
            );

            return $this->redirect( $this->generateUrl( 'list_contestentries' ) );
        }

        return $this->render(
            array(
                'contestForm' => $form->createView(),
                'contest'     => $contest,
                'playerList'  => $avaliablePlayers
            )
        );
    }

    /**
     * Shows a form for Updating a contestEntry.
     *
     * @Route("/manageentry/{id}", name="update_contestentry")
     * @Template("GameBundle:ContestEntry:update.html.twig")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateEntryAction( Request $request )
    {
        $em           = $this->getDoctrine()->getManager();
        $id           = $request->attributes->get( 'id' );
        $contestEntry = $em->getRepository( 'GameBundle:ContestEntry' )->find( $id );

        if ( ! $contestEntry) {
            throw $this->createNotFoundException(
                'No ContestEntry found with id: '.$id.' Found!'
            );
        }

        $contestHelper = $this->get( 'contest_helper' );

        $contest = $contestEntry->getContest();

        $avaliablePlayers = $contestHelper->getPlayersforContestResult( $contest );

        $form = $this->createForm( 'contestEntry', $contestEntry );

        $form->handleRequest( $request );

        if ($form->isValid()) {
            //check there are no duplicate players
            $uniquePlayers = $contestHelper->checkPlayersAreUnique( $contestEntry );
            $notOverBudget = $contestHelper->

            $em = $this->getDoctrine()->getManager();
            $em->persist( $contestEntry );
            $em->flush();

            $this->addFlash(
                'notice',
                'Contest Entry Updated!!'
            );

            return $this->redirect( $this->generateUrl( 'list_contestentries' ) );
        }

        return array(
            'contestEntry' => $contestEntry,
            'contestForm'  => $form->createView(),
            'contest'      => $contest,
            'playerList'   => $avaliablePlayers
        );
    }

    public function ajaxAction( Request $request )
    {
        $contest = new Contest();
        $form    = $this->createForm( 'contest', $contest );
        $form->handleRequest( $request );

        return $this->render(
            'GameBundle:Forms:ajax_contestform.partial.twig',
            array(
                'contestForm' => $form->createView(),
            )
        );
    }

    public function getGamesForScheduleGroupAction( $id )
    {
        $repo = $this->getDoctrine()->getRepository( 'GameBundle:ScheduleGroup' );

        $schedules = $repo->getScheduleGroup( $id );

        return $this->render(
            'GameBundle:Forms:schedule_group_games.html.twig',
            array(
                'schedules' => $schedules
            )
        );
    }

    public function getPrizesAction( $playerCount, $gameFee, $payoutStructure )
    {
        $prizeHelper = $this->get( 'prize_helper' );
        $prizes      = $prizeHelper->generatePrizes( $playerCount, $gameFee, $payoutStructure );


        return $this->render(
            'GameBundle:Forms:payout_list.partial.twig',
            array(
                'prizes' => $prizes
            )
        );
    }

}


