<?php

namespace FantasyPro\GameBundle\Form\Transformers;

use FantasyPro\DataBundle\Entity\Team;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TeamToPlayerIdTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct( ObjectManager $manager )
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (team) to a string (playerID).
     *
     * @param  Team|null $team
     *
     * @return string
     */
    public function transform( $team )
    {
        if (null === $team) {
            return '';
        }

        return $team->getPlayerID();
    }

    /**
     * Transforms a string (playerID) to an object (team).
     *
     * @param  string $playerID
     *
     * @return Team|null
     * @throws TransformationFailedException if object (team) is not found.
     */
    public function reverseTransform( $playerID )
    {
        if ( ! $playerID) {
            return null;
        }

        $team = $this->manager
            ->getRepository( 'DataBundle:Team' )
            // query for the team with this playerID
            ->findOneBy( array( 'playerID' => $playerID ) );

        if (null === $team) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(
                sprintf(
                    'A team with playerID "%s" does not exist!',
                    $team
                )
            );
        }

        return $team;
    }
}