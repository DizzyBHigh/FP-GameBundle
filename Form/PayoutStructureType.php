<?php

namespace FantasyPro\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PayoutStructureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'name' );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FantasyPro\GameBundle\Entity\PayoutStructure'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fantasypro_gamebundle_payoutstructure';
    }
}
