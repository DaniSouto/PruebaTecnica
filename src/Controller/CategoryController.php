<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request, CategoryRepository $repository)
    {

        $categories = $repository->findAll();
        $msg        = $request->get('msg', null);

        return [
            'categories' => $categories,
            'msg'        => $msg,
        ];

    }

    /**
     * @Route("/{id}/view", name="app.category.view", methods={"GET"})
     * @Template()
     */
    public function view(Category $category)
    {

        return [
            'category' => $category,
        ];
    }

    /**
     * @Route("/create", name="app.category.create", methods={"GET"})
     * @Template()
     */
    public function createAction()
    {
        return;
    }


    /**
     * @Route("/create", name="app.category.store", methods={"POST"})
     */
    public function storeAction(Request $request)
    {

        $_name          = $request->get('name', null);
        $_priority      = $request->get('priority', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $newCategory = new Category();

        $newCategory->setName($_name);
        $newCategory->setPriority($_priority);

        $entityManager->persist($newCategory);
        $entityManager->flush();

        return $this->redirectToRoute('app.category.index', [
            'msg'   => 'Categoría creada con éxito.',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app.category.edit", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function editAction(Category $category)
    {

        return [
            'category' => $category,
        ];
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="\d{1,9}"}, methods={"POST"})
     * @Template()
     */
    public function updateAction(Category $category, Request $request)
    {

        $_name     = $request->get('name', null);
        $_priority = $request->get('priority', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $category->setName($_name);
        $category->setPriority($_priority);

        $entityManager->flush();

        return $this->redirectToRoute('app.category.index', [
            'msg'   => 'Categoría actualizada con éxito.',
        ]);

    }

    /**
     * @Route("/{id}/remove", name="app.category.remove", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function remove(Category $category)
    {

        $category->setDeletedAt(new \DateTime());

        $entityManager  = $this->getDoctrine()->getManager();

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('app.category.index', [
            'msg'   => 'Categoría eliminada con éxito.',
        ]);
    }

}