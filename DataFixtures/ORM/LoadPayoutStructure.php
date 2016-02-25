<?php
/**
 * LoadPayoutStructure.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FantasyPro\GameBundle\Entity\PayoutStructure;


class LoadPayoutStructure implements FixtureInterface
{

    public function load( ObjectManager $manager )
    {
        /**
         * payoutStructure:
         * 1: Winner Takes all
         * 2: Top 3 get Prizes
         * 3: Top Third Get Prizes
         */
        $payoutStructureArray = array(
            'Winner Takes all',
            'Top 3 get Prizes',
            'Top Third Get Prizes'
        );

        foreach ($payoutStructureArray as $value) {
            $payoutStructure = new PayoutStructure();
            $payoutStructure->setName( $value );
            $manager->persist( $payoutStructure );
            $manager->flush();
        }

    }

}