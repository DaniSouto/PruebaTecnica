<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Editorial;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="app.book.index")
     * @Template()
     */
    public function indexAction(Request $request, BookRepository $repository)
    {
        $term   = $request->get('search_term', null);
        $msg    = $request->get('msg', null);
        $books  = null;

        if($term){
            $books = $repository->findByTitle($term);
        }
        else {
            $books = $repository->findAll();
        }

        return [
            'books' => $books,
            'msg'   => $msg,
            'term'  => $term,
        ];

    }

    /**
     * @Route("/{id}/view", name="app.book.view", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function viewAction(Book $book)
    {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $editorials = $this->getDoctrine()
            ->getRepository(Editorial::class)
            ->findAll();

        $authors    = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();


        return [
            'categories'    => $categories,
            'editorials'    => $editorials,
            'authors'       => $authors,
            'book'          => $book,
        ];
    }

    /**
     * @Route("/create", name="app.book.create", methods={"GET"})
     * @Template()
     */
    public function createAction()
    {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $editorials = $this->getDoctrine()
            ->getRepository(Editorial::class)
            ->findAll();

        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();


        return [
            'categories'    => $categories,
            'editorials'    => $editorials,
            'authors'       => $authors,
        ];
    }


    /**
     * @Route("/create", name="app.book.store", methods={"POST"})
     */
    public function storeAction(Request $request)
    {

        $_title         = $request->get('title', null);
        $_description   = $request->get('description', null);
        $_category_id   = $request->get('category', null);
        $_editorial_id  = $request->get('editorial', null);
        $_author_id     = $request->get('author', null);
        $_stock         = $request->get('stock', 0);
        $_priority        = $request->get('priority', 0);

        $category       = $this->getDoctrine()->getRepository(Category::class)->findOneById($_category_id);
        $editorial      = $this->getDoctrine()->getRepository(Editorial::class)->findOneById($_editorial_id);
        $author         = $this->getDoctrine()->getRepository(Author::class)->findOneById($_author_id);

        $entityManager  = $this->getDoctrine()->getManager();

        $book = new Book();

        $book->setTitle($_title);
        $book->setDescription($_description);
        $book->setCategory($category);
        $book->setEditorial($editorial);
        $book->setAuthor($author);
        $book->setStock($_stock);
        $book->setPriority($_priority);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app.book.index', [
            'msg'   => 'Libro creado con éxito.',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app.book.edit", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function editAction(Book $book)
    {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $editorials = $this->getDoctrine()
            ->getRepository(Editorial::class)
            ->findAll();

        $authors    = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();


        return [
            'categories'    => $categories,
            'editorials'    => $editorials,
            'authors'       => $authors,
            'book'          => $book,
        ];
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="\d{1,9}"}, methods={"POST"})
     * @Template()
     */
    public function updateAction(Book $book, Request $request)
    {

        $_title         = $request->get('title', null);
        $_description   = $request->get('description', null);
        $_category_id   = $request->get('category', null);
        $_editorial_id  = $request->get('editorial', null);
        $_author_id     = $request->get('author', null);
        $_stock         = $request->get('stock', 0);

        $category       = $this->getDoctrine()->getRepository(Category::class)->findOneById($_category_id);
        $editorial      = $this->getDoctrine()->getRepository(Editorial::class)->findOneById($_editorial_id);
        $author         = $this->getDoctrine()->getRepository(Author::class)->findOneById($_author_id);

        $entityManager  = $this->getDoctrine()->getManager();

        $book->setTitle($_title);
        $book->setDescription($_description);
        $book->setCategory($category);
        $book->setEditorial($editorial);
        $book->setAuthor($author);
        $book->setStock($_stock);

        $entityManager->flush();

        return $this->redirectToRoute('app.book.index', [
            'msg'   => 'Libro creado con éxito.',
        ]);
    }

    /**
     * @Route("/{id}/remove", name="app.book.remove", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function remove(Book $book)
    {

        $book->setDeletedAt(new \DateTime());

        $entityManager  = $this->getDoctrine()->getManager();

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app.book.index', [
            'msg'   => 'Libro eliminado con éxito.',
        ]);
    }

}