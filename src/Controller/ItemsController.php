<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ConditionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ItemsRepository;
use Detection\MobileDetect;
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
            $itemPerPage = 3;
        } else {
            $itemPerPage = 8;
        }
        $pagination = $itemsRepo->paginateItems($request, $itemPerPage);
        return $this->render('items/index.html.twig', [
            'pagination' => $pagination,
            'allCategory' => $allCategory
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

    #[Route('items/status/{id}', name: 'app-status', methods: ['GET'])]
    public function statusByItem(Request $request, ConditionsRepository $conditionsRepo): JsonResponse
    {
        $id = $request->get('id');
        $status = $conditionsRepo->findOneBy(['id' => $id]);
        return $this->json($status->getStatus());
    }
}
