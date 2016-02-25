<?php
/**
 * dateToStringTransformer.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\Form\Transformers;


class dateToStringTransformer
{
    /**
     * @param $dateObj
     *
     * @return string
     */
    public function transform( $dateObj )
    {
        if (null === $dateObj) {
            return "";
        }

        return $dateObj->format( 'm/d/Y : h:m a' );
    }

    /**
     * @param $date
     *
     * @return \DateTime|null
     */
    public function reverseTransform( $date )
    {
        if ($date === "") {
            return null;
        }
        $dateObj = new \DateTime( $date );

        return $dateObj;
    }
}