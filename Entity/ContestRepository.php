<?php

namespace FantasyPro\GameBundle\Entity;


/**
 * ContestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContestRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllByUser( $user )
    {
        $query = $this->createQueryBuilder( 'c' )
                      ->select( 'c' )
                      ->Where( ':user MEMBER OF c.users' )
                      ->setParameter( 'user', $user );

        return $query->getQuery()->getResult();
    }
}
