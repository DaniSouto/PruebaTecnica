<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{

    /**
     * @Route("/", name="app.author.index")
     * @Template()
     */
    public function index(AuthorRepository $repository)
    {
        $authors = $repository->findAll();
        return [
            'authors'   => $authors,
        ];
    }

}