<?php

namespace App\Controller;

use App\Repository\EditorialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editorial")
 */
class EditorialController extends AbstractController
{
    /**
     * @Route("/", name="app.editorial.index")
     * @Template()
     */
    public function index(EditorialRepository $repository)
    {

        $editorials = $repository->findAll();

        return [
            'editorials'   => $editorials,
        ];

    }

}