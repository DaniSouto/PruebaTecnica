<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Store;
use App\Repository\StoreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/store")
 */
class StoreController extends AbstractController
{
    /**
     * @Route("/", name="app.store.index")
     * @Template()
     */
    public function index(Request $request, StoreRepository $repository)
    {

        $term_title = $request->get('search_term_title', null);
        $msg        = $request->get('msg', null);
        $stores      = null;

        if($term_title){
            $stores = $repository->findByTitle($term_title);
        }else{
            $stores = $repository->findAll();
        }

        return [
            'term_title' => $term_title,
            'stores'     => $stores,
            'msg'        => $msg
        ];

    }

    /**
     * @Route("/{id}/view", name="app.store.view", methods={"GET"})
     * @Template()
     */
    public function view(Store $store)
    {

        $stoks = $this->getDoctrine()
                        ->getRepository(Stock::class)
                            ->findStockByStoreId($store->getId());

        return [
            'store'  => $store,
            'stocks' => $stoks,
        ];
    }

    /**
     * @Route("/create", name="app.store.create", methods={"GET"})
     * @Template()
     */
    public function createAction()
    {
        return;
    }


    /**
     * @Route("/create", name="app.store.store", methods={"POST"})
     */
    public function storeAction(Request $request)
    {

        $_name     = $request->get('name', null);
        $_city     = $request->get('city', null);
        $_address  = $request->get('address', null);
        $_priority = $request->get('priority', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $newStore = new Store();

        $newStore->setName($_name);
        $newStore->setCity($_city);
        $newStore->setAddress($_address);
        $newStore->setPriority($_priority);

        $entityManager->persist($newStore);
        $entityManager->flush();

        return $this->redirectToRoute('app.store.index', [
            'msg'   => 'Tienda creada con éxito.',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app.store.edit", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function editAction(Store $store)
    {

        return [
            'store' => $store,
        ];
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="\d{1,9}"}, methods={"POST"})
     * @Template()
     */
    public function updateAction(Store $store, Request $request)
    {

        $_name     = $request->get('name', null);
        $_city     = $request->get('city', null);
        $_address  = $request->get('address', null);
        $_priority = $request->get('priority', null);

        $entityManager  = $this->getDoctrine()->getManager();

        $store->setName($_name);
        $store->setCity($_city);
        $store->setAddress($_address);
        $store->setPriority($_priority);

        $entityManager->flush();

        return $this->redirectToRoute('app.store.index', [
            'msg'   => 'Tienda actualizada con éxito.',
        ]);

    }

    /**
     * @Route("/{id}/remove", name="app.store.remove", requirements={"id"="\d{1,9}"}, methods={"GET"})
     * @Template()
     */
    public function remove(Store $store)
    {

        $store->setDeletedAt(new \DateTime());

        $entityManager  = $this->getDoctrine()->getManager();

        $entityManager->persist($store);
        $entityManager->flush();

        return $this->redirectToRoute('app.store.index', [
            'msg'   => 'Tienda eliminada con éxito.',
        ]);
    }

}
