<?php

namespace FantasyPro\GameBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use FantasyPro\GameBundle\Form\Transformers\dateToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleGroupType extends AbstractType
{

    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {

        $qb = $this->em->getRepository( 'DataBundle:Schedule' )->getRemainingSchedulesQuery();
        $builder
            ->add( 'name', 'text' )
            ->add(
                'schedules',
                'entity',
                array(
                    'class'         => 'DataBundle:Schedule',
                    'property'      => 'hrDate',
                    'label'         => 'Select Schedules',
                    'placeholder'   => 'Select Schedules',
                    'query_builder' => $qb,
                    'multiple'      => true,
                    'expanded'      => true
                )
            )
            ->getForm();
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults(
            array( 'data_class' => 'GameBundle\Entity\ScheduleGroups' )
        );
    }

    public function getName()
    {
        return 'schedulegroups';
    }

}