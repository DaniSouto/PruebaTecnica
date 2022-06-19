<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Stock;
use App\Entity\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/stock")
 */
class StockController extends AbstractController
{
    /**
     * @Route("/", name="app.stock.index")
     */
    public function index(): Response
    {
        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    /**
     * @Route("/create", name="app.stock.create", methods={"GET"})
     * @Template()
     */
    public function createAction(Request $request)
    {

        $books = $this->getDoctrine()
                        ->getRepository(Book::class)
                            ->findAll();

        $stores = $this->getDoctrine()
                        ->getRepository(Store::class)
                            ->findAll();


        return [
            'books'  => $books,
            'stores' => $stores
        ];

    }


    /**
     * @Route("/create", name="app.stock.store", methods={"POST"})
     */
    public function storeAction(Request $request)
    {

        $_store  = $request->get('store', null);
        $_book   = $request->get('book', null);
        $_units  = $request->get('units', null);

        $entityManager  = $this->getDoctrine()->getManager();

        //TODO update stock (Entity:Stock) when store_id and book_id are already in DB
        //TODO udpate stock (Entity:Book) when units are inserted or udpated
        $newStock = new Stock();

        $newStock->setStoreId($_store);
        $newStock->setBookId($_book);
        $newStock->setUnits($_units);

        $entityManager->persist($newStock);
        $entityManager->flush();

        return $this->redirectToRoute('app.store.index', [
            'msg' => 'Stock añadido con éxito.',
        ]);
    }

}
