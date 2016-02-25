<?php

namespace FantasyPro\GameBundle\Form\Transformers;

use FantasyPro\DataBundle\Entity\Player;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PlayerToPlayerIdTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct( ObjectManager $manager )
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (player) to a string (id).
     *
     * @param Player $player
     *
     * @return string
     * @internal param Player|null $player
     */
    public function transform( $player )
    {
        if (null === $player) {
            return '';
        }

        return $player->getId();
    }

    /**
     * Transforms a string (playerID) to an object (team).
     *
     * @param  string $id
     *
     * @return Player|null
     * @throws TransformationFailedException if object (player) is not found.
     */
    public function reverseTransform( $id )
    {
        if ( ! $id) {
            return null;
        }

        $player = $this->manager
            ->getRepository( 'DataBundle:Player' )
            // query for the player with this Id
            ->find( $id );

        if (null === $player) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(
                sprintf(
                    'A player with id "%s" does not exist!',
                    $player
                )
            );
        }

        return $player;
    }
}