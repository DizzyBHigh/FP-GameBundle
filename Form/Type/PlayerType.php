<?php
namespace FantasyPro\GameBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlayerType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add( 'id', 'hidden' );
    }

    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FantasyPro\DataBundle\Entity\Player'
            )
        );
    }

    public function getName()
    {
        return 'player';
    }
}