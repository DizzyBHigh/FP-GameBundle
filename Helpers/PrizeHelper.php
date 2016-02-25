<?php
/**
 * PrizeHelper.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 10, 2015
 */

namespace FantasyPro\GameBundle\Helpers;


use Doctrine\ORM\EntityManager;

class PrizeHelper
{
    /** @var array $payoutTable */
    public $payoutTable;
    public $em;

    public function __construct( EntityManager $em )
    {
        $this->payoutTable = array(
            1  => array( 100 ),
            2  => array( 100 ),
            3  => array( 70, 30 ),
            4  => array( 72, 28 ),
            5  => array( 69, 31 ),
            6  => array( 67, 33 ),
            7  => array( 65, 35 ),
            8  => array( 50, 30, 20 ),
            9  => array( 49, 31, 20 ),
            10 => array( 48, 31, 21 ),
            11 => array( 45, 28, 16, 11 ),
            12 => array( 44, 28, 16, 12 ),
            13 => array( 43, 28, 16, 14 ),
            14 => array( 37, 22, 18, 14, 9 ),
            15 => array( 36, 22, 19, 14, 9 ),
            16 => array( 36, 22, 19, 14, 9 ),
            17 => array( 33, 21, 16, 13, 10, 7 ),
            18 => array( 33, 21, 17, 13, 10, 6 ),
            19 => array( 34, 21, 16, 13, 9, 7 ),
            20 => array( 32, 22, 16, 13, 10, 7 ),
        );
        $this->em          = $em;
    }

    /**
     * @return array
     */
    public function getPayoutTable( $playerCount )
    {
        return $this->payoutTable[$playerCount];
    }

    public function generatePrizes( $playerCount, $gameFee, $payoutStructure )
    {
        $structure = $this->getPayoutTable( 1 );

        $entryFeeRepo = $this->em->getRepository( 'GameBundle:EntryFee' );
        $entryFee     = $entryFeeRepo->findOneBy( array( 'id' => $gameFee ) );
        $entryCost    = $entryFee->getEntryFee();

        $paid   = $entryCost * $playerCount;
        $pot    = ( $paid / 100 * 90 );
        $scrape = ( $paid / 100 * 10 );
        $prizes = array();

        /**
         * payoutStructure:
         * 1: Winner Takes all
         * 2: Top 3 get Prizes
         * 3: Top Third Get Prizes
         */

        if ($payoutStructure == 1) {
            $structure = $this->getPayoutTable( 1 );
        }
        if ($payoutStructure == 2) {

            if ($playerCount >= 4) {
                $structure = $this->getPayoutTable( 8 );
            } else {
                $structure = $this->getPayoutTable( 3 );
            }
        }
        if ($payoutStructure == 3) {
            $structure = $this->getPayoutTable( $playerCount );
        }

        $pCount = 1;
        $total  = 0;
        foreach ($structure as $payout) {
            $prize           = ( $pot / 100 * $payout );
            $total           = ( $total + $prize );
            $prizes[$pCount] = $prize;
            $pCount++;
        }

        return $prizes;
    }


}