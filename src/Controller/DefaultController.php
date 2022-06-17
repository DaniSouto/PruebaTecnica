<?php

namespace App\Controller;

use App\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app.index")
     * @Template("home.html.twig")
     */
    public function indexAction()
    {
        return [];
    }

}