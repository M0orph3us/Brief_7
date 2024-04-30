<?php

namespace App\Controller;

use App\Entity\Items;
use App\Repository\CategoriesRepository;
use App\Repository\ConditionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ItemsRepository;
use Detection\MobileDetect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ItemsController extends AbstractController
{
    #[Route('/items', name: 'app_items', methods: ['GET'])]
    public function index(ItemsRepository $itemsRepo, CategoriesRepository $categoryRepo, Request $request): Response
    {

        $allCategory = $categoryRepo->findAll();
        $detect = new MobileDetect();
        $isMobile = $detect->isMobile();
        if ($isMobile === true) {
            $pagination = $itemsRepo->findAll();
            // $mobile = true;
        } else {
            $pagination = $itemsRepo->paginateItems($request, 8);
            // $mobile = false;
        }
        return $this->render('items/index.html.twig', [
            'pagination' => $pagination,
            'allCategory' => $allCategory,
            'mobile' => $isMobile
        ]);
    }

    #[Route('/items/{category}', name: 'items-by-category', methods: ['GET'])]
    public function itemsByCategory(Request $request, ItemsRepository $itemsRepo): JsonResponse
    {

        $category = $request->get('category');
        $itemsByCategory = $itemsRepo->paginateItemsByCategory($category);

        // $detect = new MobileDetect();
        // $isMobile = $detect->isMobile();
        // if ($isMobile === true) {
        //     $itemPerPage = 3;
        // } else {
        //     $itemPerPage = 8;
        // }
        // $pagination = "";
        return $this->json($itemsByCategory);
    }

    #[Route('/items/status/{id}', name: 'app-status', methods: ['GET'])]
    public function statusByItem(Request $request, ConditionsRepository $conditionsRepo): JsonResponse
    {
        $id = $request->get('id');
        $status = $conditionsRepo->findOneBy(['id' => $id]);
        return $this->json($status->getStatus());
    }

    #[Route('/items/detail/{id}', name: 'item-detail', methods: ['GET'])]
    public function detailItem(Items $item): Response
    {

        return $this->render('items/detail.html.twig', [
            'item' => $item
        ]);
    }

    #[Route('/items/add/{id}', name: 'item-add-cart', methods: ['GET'])]
    public function buyItem(Items $item, EntityManagerInterface $em, Request $request): Response
    {
        $stock = $item->getStock();
        $item->setStock($stock - 1);

        $idItem = $request->get('id');
        $item->addBuyer($this->getUser());
        $em->flush();
        $this->addFlash('success', 'item add to your cart');
        return $this->redirectToRoute('item-detail', ['id' => $idItem]);
    }
}
