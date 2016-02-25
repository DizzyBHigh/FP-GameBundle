<?php

namespace FantasyPro\GameBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScheduleGroupsType extends AbstractType
{

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
        $qb = $this->em->getRepository( 'DataBundle:Schedule' )->getAllSchedulesQuery();
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
            ->getForm();;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FantasyPro\GameBundle\Entity\ScheduleGroup'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'schedulegroups';
    }
}
