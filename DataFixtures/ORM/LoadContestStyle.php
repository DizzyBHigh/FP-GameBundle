<?php
/**
 * LoadContestStyles.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FantasyPro\GameBundle\Entity\ContestStyle;


class LoadContestStyle implements FixtureInterface
{

    public function load( ObjectManager $manager )
    {

        $contestStyleArray = array(
            'Head To Head',
            'League',
        );

        foreach ($contestStyleArray as $value) {
            $contestStyle = new ContestStyle();
            $contestStyle->setname( $value );
            $manager->persist( $contestStyle );
            $manager->flush();
        }
    }
}