<?php

namespace FantasyPro\GameBundle\Form;

use Doctrine\ORM\EntityManager;
use FantasyPro\GameBundle\Entity\Contest;
use FantasyPro\GameBundle\Form\Type\EntityHiddenType;
use FantasyPro\GameBundle\Form\Type\PlayerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContestEntryType extends AbstractType
{

    public $em;

    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add(
                'user',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\UserBundle\Entity\User'
                )
            )
            ->add(
                'contest',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\GameBundle\Entity\Contest'
                )
            )
            ->add(
                'qb',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'rb1',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'rb2',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'wr1',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'wr2',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'te',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'k',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add(
                'flex',
                'entity_hidden',
                array(
                    'class' => 'FantasyPro\DataBundle\Entity\Player'
                )
            )
            ->add( 'def', 'team_hidden' )
            ->add(
                'save',
                'submit',
                array(
                    'label' => 'Enter Contest',
                    'attr'  => array(
                        'class' => 'btn-sm btn-info'
                    )
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FantasyPro\GameBundle\Entity\ContestEntry',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contestEntry';
    }
}
