<?php

namespace FantasyPro\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $contestRepo = $this->getDoctrine()->getRepository( 'GameBundle:Contest' );

        $contests = $contestRepo->findAll();

        return $this->render(
            'GameBundle:Default:index.html.twig',
            array(
                'contests' => $contests
            )
        );
    }

}
