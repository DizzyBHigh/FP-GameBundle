<?php
/**
 * EntryFeeType.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Type extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {

        $builder->add(
            'entryFee',
            'choice',
            array(
                'choices' => array(
                    0   => 'free practice',
                    1   => '£1',
                    2   => '£2',
                    5   => '£5',
                    10  => '£10',
                    25  => '£25',
                    50  => '£50',
                    75  => '£75',
                    100 => '£100'
                )
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'array_choice';
    }
}