<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{

    /**
     * @Route("/", name="app.category.index")
     * @Template()
     */
    public function index(CategoryRepository $repository)
    {

        $categories = $repository->findAll();

        return [
            'categories'   => $categories,
        ];

    }

}