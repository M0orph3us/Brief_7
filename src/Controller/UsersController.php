<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
    #[Route('/user/{id}/cart', name: 'user-cart', methods: ['GET'])]
    public function cart(Users $user): Response
    {
        $getOrders = $user->getOrders();
        return $this->render('users/cart.html.twig', [
            'orders' => $getOrders
        ]);
    }

    #[Route('/user/profil/{id}', name: 'user-profil', methods: ['GET'])]
    public function profil(Users $user): Response
    {
        return $this->render('users/cart.html.twig', [
            'user' => $user
        ]);
    }
}