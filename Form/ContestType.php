<?php
namespace FantasyPro\GameBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContestType extends AbstractType
{
    protected $em;

    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults(
            array( 'data_class' => 'GameBundle\Entity\Contest' )
        );
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add(
                'scheduleGroup',
                'entity',
                array(
                    'class'       => 'GameBundle:ScheduleGroup',
                    'property'    => 'name',
                    'label'       => 'Date',
                    'placeholder' => 'Select Date',
                )
            )
            ->add(
                'contestStyle',
                'entity',
                array(
                    'class'    => 'GameBundle:ContestStyle',
                    'property' => 'name',
                    'label'    => 'Contest Style',
                    //'expanded' => true,
                    //'multiple' => false,
                )
            )
            ->add(
                'entryFee',
                'entity',
                array(
                    'class'    => 'GameBundle:EntryFee',
                    'property' => 'entryFeeString',
                    'label'    => 'Entry Fee',
                    //'expanded' => true,
                    //'multiple' => false,
                )
            )
            ->add(
                'playerCount',
                'hidden',
                array(
                    'data'  => '2',
                    'label' => 'Head To Head'
                )
            )
            ->add(
                'payoutStructure',
                'entity',
                array(
                    'class'    => 'GameBundle:PayoutStructure',
                    'property' => 'name',
                    'label'    => 'Payout Structure',
                    //'expanded' => true,
                    //'multiple' => false,
                )
            )
            ->add(
                'name',
                'text',
                array(
                    'label' => 'Name'
                )
            )
            ->add(
                'initialised',
                'hidden',
                array(
                    'data' => 'false'
                )
            )
            ->getForm();

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function ( FormEvent $event ) {
                $form = $event->getForm();

                $data         = $event->getData();
                $contestStyle = $data->getContestStyle()->getID();;
                $playerCountOptions = array(
                    3  => '3 Players',
                    4  => '4 Players',
                    5  => '5 Players',
                    6  => '6 Players',
                    7  => '7 Players',
                    8  => '8 Players',
                    9  => '9 Players',
                    10 => '10 Players',
                    11 => '11 Players',
                    12 => '12 Players',
                    13 => '13 Players',
                    14 => '14 Players',
                    15 => '15 Players',
                    16 => '16 Players',
                    17 => '17 Players',
                    18 => '18 Players',
                    19 => '19 Players',
                    20 => '20 Players',
                );
                $list               = null === $contestStyle ? array() : $playerCountOptions;

                if ($contestStyle > 1) {
                    $form->remove( 'playerCount' );
                    $form->add(
                        'playerCount',
                        'choice',
                        array(
                            'choices' => $list,
                            'label'   => 'Number of Players',
                        )
                    );
                }
            }
        );
    }

    public function getName()
    {
        return 'contest';
    }
}