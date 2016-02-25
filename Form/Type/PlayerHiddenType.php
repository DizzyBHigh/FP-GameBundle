<?php
namespace FantasyPro\GameBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use FantasyPro\GameBundle\Form\Transformers\PlayerToPlayerIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlayerHiddenType extends AbstractType
{

    private $manager;

    public function __construct( ObjectManager $manager )
    {
        $this->manager = $manager;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {

        $transformer = new PlayerToPlayerIdTransformer( $this->manager );
        $builder->addModelTransformer( $transformer );
    }

    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver
            ->setDefaults(
                array(
                    'invalid_message' => 'The Player does not exist.',
                )
            );
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'player_hidden';
    }
}