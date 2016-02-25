<?php
/**
 * LoadEntryFees.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FantasyPro\GameBundle\Entity\EntryFee;


class LoadEntryFees implements FixtureInterface
{

    public function load( ObjectManager $manager )
    {

        $entryFeeArray = array(
            'Free Practice' => 0,
            '£1'            => 1,
            '£2'            => 2,
            '£5'            => 5,
            '£10'           => 10,
            '£25'           => 25,
            '£50'           => 50,
            '£100'          => 100
        );

        foreach ($entryFeeArray as $key => $value) {
            $entryFee = new EntryFee();
            $entryFee->setEntryFeeString( $key );
            $entryFee->setEntryFee( $value );
            $manager->persist( $entryFee );
            $manager->flush();
        }

    }

}