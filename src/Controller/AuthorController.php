<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{

    /**
     * @Route("/", name="app.author.index")
     * @Template()
     */
    public function index(Request $request, AuthorRepository $repository)
    {

        $authors = $repository->findAll();
        $msg     = $request->get('msg', null);

        return [
            'authors' => $authors,
            'msg'     => $msg
        ];
    }

    /**
     * @Route("/{id}/view", name="app.author.view", methods={"GET"})
     * @Template()
     */
    public function view(Author $author)
    {

        return [
            'author' => $author,
        ];
    }

    /**
     * @Route("/create", name="app.author.create", methods={"GET"})
     * @Template()
     */
    public function createAction()
    {
        return;
    }


    /**
     * @Route("/create", name="app.author.store", methods={"POST"})
     */
    public function storeAction(Request $request)
    {

        $_name     = $request->get('name', null);
        $_priority = $request->get('priority', null);
        $_birth    = $request->get('birth', null);
        $_age      = $request->get('age', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $newAuthor = new Author();

        $newAuthor->setName($_name);
        $newAuthor->setPriority($_priority);
        $newAuthor->setBirth($_birth);
        $newAuthor->setAge($_age);

        $entityManager->persist($newAuthor);
        $entityManager->flush();

        return $this->redirectToRoute('app.author.index', [
            'msg'   => 'Autor creado con éxito!',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app.author.edit", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function editAction(Author $author)
    {

        return [
            'author'          => $author,
        ];
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="\d{1,9}"}, methods={"POST"})
     * @Template()
     */
    public function updateAction(Author $author, Request $request)
    {

        $_name     = $request->get('name', null);
        $_priority = $request->get('priority', null);
        $_birth    = $request->get('birth', null);
        $_age      = $request->get('age', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $author->setName($_name);
        $author->setPriority($_priority);
        $author->setBirth($_birth);
        $author->setAge($_age);

        $entityManager->flush();

        return $this->redirectToRoute('app.author.index', [
            'msg'   => 'Autor actualizado con éxito.',
        ]);

    }

    /**
     * @Route("/{id}/remove", name="app.author.remove", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function remove(Author $author)
    {

        $author->setDeletedAt(new \DateTime());

        $entityManager  = $this->getDoctrine()->getManager();

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->redirectToRoute('app.author.index', [
            'msg'   => 'Autor eliminado con éxito.',
        ]);
    }

}