<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/user/cart/delete/{id}', name: 'item-delete-cart', methods: ['GET'])]
    public function deleteItem(Items $item, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $user->removeOrder($item);
        $stock = $item->getStock();
        $item->setStock($stock + 1);
        $em->flush();
        $this->addFlash('success', 'item delete to your cart');
        return $this->redirectToRoute('user-cart', ['id' => $userId]);
    }

    #[Route('/user/profil/{id}', name: 'user-profil', methods: ['GET'])]
    public function profil(Users $user): Response
    {
        return $this->render('users/cart.html.twig', [
            'user' => $user
        ]);
    }
}