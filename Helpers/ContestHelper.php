<?php
/**
 * ContestHelper.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\Helpers;

use Doctrine\ORM\EntityManager;
use FantasyPro\DataBundle\Entity\Schedule;
use FantasyPro\DataBundle\Helpers\DateHelper;
use FantasyPro\GameBundle\Entity\Contest;
use FantasyPro\GameBundle\Entity\ContestEntry;

class ContestHelper
{

    /**
     * @var EntityManager $em (fantasydata entity manager)
     */
    private $em;
    private $dateHelper;

    public function __construct( EntityManager $em, DateHelper $dateHelper )
    {
        $this->em         = $em;
        $this->dateHelper = $dateHelper;
    }

    /**
     * @param $id
     *
     * @return Contest
     */
    public function getContest( $id )
    {
        $contestRepo = $this->em->getRepository( 'GameBundle:Contest' );
        $contest     = $contestRepo->find( $id );

        return $contest;
    }

    /**
     * @param Contest $contest
     *
     * @return Schedule
     */
    public function getContestSchedules( Contest $contest )
    {
        $scheduleGroupRepo = $this->em->getRepository( 'GameBundle:ScheduleGroup' );
        $schedules         = $scheduleGroupRepo->getScheduleGroup( $contest->getScheduleGroup() );

        return $schedules;
    }

    public function getContestTeams( Contest $contest )
    {

        $schedules  = $this->getContestSchedules( $contest );
        $teamsArray = array();
        foreach ($schedules as $schedule) {
            $hometeam = $schedule->getHomeTeam();
            $awayteam = $schedule->getAwayTeam();
            array_push( $teamsArray, $hometeam );
            array_push( $teamsArray, $awayteam );
        }

        return $teamsArray;

    }

    public function getContestDates( Contest $contest )
    {
        /** @var Schedule $schedules */
        $schedules = $this->getContestSchedules( $contest );
        $dateArray = array();

        foreach ($schedules as $schedule) {
            $date          = $schedule->getDateOnly();
            $formattedDate = $this->dateHelper->apiDate( $date );
            array_push( $dateArray, $formattedDate );
        }

        return $dateArray;
    }

    public function getPlayersforContestQuery( Contest $contest )
    {
        $this->getContestTeams( $contest );
        //get the repos
        $playerRepo = $this->em->getRepository( 'DataBundle:DailyFantasyPlayer' );
        $teamsArray = $this->getContestTeams( $contest );
        $dateArray  = $this->getContestDates( $contest );
        $qb         = $playerRepo->getPlayersByTeamQuery( $teamsArray, $dateArray );

        return $qb;
    }

    public function getPlayersforContestResult( Contest $contest )
    {
        $qb = $this->getPlayersforContestQuery( $contest );

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ContestEntry $contestEntry
     *
     * @return bool
     */
    public function entryPlayersAreUnique( ContestEntry $contestEntry )
    {

        $playerArray = array(
            $contestEntry->getWr1()->getId(),
            $contestEntry->getWr2()->getId(),
            $contestEntry->getRb1()->getId(),
            $contestEntry->getRb2()->getId(),
            $contestEntry->getTe()->getId(),
            $contestEntry->getK()->getId(),
            $contestEntry->getFlex()->getId(),
            $contestEntry->getDef()->getPlayerId()
        );

        return count( $playerArray ) != count( array_unique( $playerArray ) );
    }

    public function entryNotOverBudget( ContestEntry $contestEntry )
    {
        $budget      = 50000;
        $budgetArray = array(
            $contestEntry->getWr1()->getSalary(),
            $contestEntry->getWr2()->getId(),
            $contestEntry->getRb1()->getId(),
            $contestEntry->getRb2()->getId(),
            $contestEntry->getTe()->getId(),
            $contestEntry->getK()->getId(),
            $contestEntry->getFlex()->getId(),
            $contestEntry->getDef()->getPlayerId()
        );
    }
}