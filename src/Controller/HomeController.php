<?php

namespace App\Controller;

use App\Repository\ItemsRepository;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ItemsRepository $itemsRepo, Request $request): Response
    {

        $detect = new MobileDetect();
        $isMobile = $detect->isMobile();
        if ($isMobile === true) {
            $itemPerPage = 3;
        } else {
            $itemPerPage = 8;
        }
        $pagination = $itemsRepo->paginateItems($request, $itemPerPage);
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}