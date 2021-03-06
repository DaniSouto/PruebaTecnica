<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Editorial;
use App\Entity\Stock;
use App\Entity\Store;
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
        $term_title     = $request->get('search_term_title', null);
        $term_author    = $request->get('search_term_author', null);
        $term_editorial = $request->get('search_term_editorial', null);
        $term_category  = $request->get('search_term_category', null);

        $msg    = $request->get('msg', null);
        $books  = null;

        if($term_title){
            $books = $repository->findByTitle($term_title);
        }

        if($term_author){
            $books = $repository->findByAuthor($term_author);
        }

        if($term_editorial){
            $books = $repository->findByEditorial($term_editorial);
        }

        if($term_category){
            $books = $repository->findByCategory($term_category);
        }

        if($books==null){
            $books = $repository->findAll();
        }

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
            'books'           => $books,
            'categories'      => $categories,
            'editorials'      => $editorials,
            'authors'         => $authors,
            'term_title'      => $term_title,
            'term_author'     => $term_author,
            'term_editorial'  => $term_editorial,
            'term_category'   => $term_category,
            'msg'             => $msg,
        ];

    }

    /**
     * @Route("/{id}/view", name="app.book.view", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function viewAction(Book $book)
    {

        $categories =  $this->getDoctrine()
                                ->getRepository(Category::class)
                                    ->findAll();

        $editorials =  $this->getDoctrine()
                                ->getRepository(Editorial::class)
                                    ->findAll();

        $authors =     $this->getDoctrine()
                                ->getRepository(Author::class)
                                    ->findAll();

        $stores =      $this->getDoctrine()
                                ->getRepository(Stock::class)
                                    ->findStockByBookIdGroupedByStore($book->getId());

        $suggestions = $this->getDoctrine()
                                ->getRepository(Book::class)
                                    ->findSuggestionsByBookOrderedByPriority($book);

        return [
            'categories'  => $categories,
            'editorials'  => $editorials,
            'authors'     => $authors,
            'book'        => $book,
            'stores'      => $stores,
            'suggestions' => $suggestions,
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
            'msg'   => 'Libro creado con ??xito.',
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
            'msg'   => 'Libro editado con ??xito.',
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
            'msg'   => 'Libro eliminado con ??xito.',
        ]);
    }

}