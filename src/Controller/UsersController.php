<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Users;
use App\Form\ItemFormType;
use App\Form\UserFormType;
use DateTimeImmutable;
use DateTimeZone;
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
        return $this->redirectToRoute('user-cart', ['id' => $userId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/user/profil/{id}', name: 'user-profil', methods: ['GET'])]
    public function profil(Users $user): Response
    {
        $userSell = $user->getSells();
        $form = $this->createForm(ItemFormType::class, null, [
            'action' => $this->generateUrl('user-sell', ['id' => $user->getId()])
        ]);

        return $this->render('users/index.html.twig', [
            'user' => $user,
            'userSells' => $userSell,
            'form' => $form
        ]);
    }

    #[Route('/user/sell/{id}', name: 'user-sell', methods: ['POST'])]
    public function sellItem(Users $user, Request $request, EntityManagerInterface $em): Response
    {
        $formData = $request->get('item_form');
        $form = $this->createForm(ItemFormType::class);
        $form->submit($formData);
        $data = $form->getViewData();


        if ($form->isSubmitted() && $form->isValid()) {
            $timezone = new DateTimeZone('Europe/Paris');
            $item = new Items();
            $item
                ->setName($data->getName())
                ->setPrice($data->getPrice())
                ->setStock($data->getStock())
                ->setDescription($data->getDescription())
                ->setCategory($data->getCategory())
                ->setSubcategory($data->getSubcategory())
                ->setStatus($data->getStatus())
                ->setCreatedAt(new DateTimeImmutable('now', $timezone));
            $user->addSell($item);
            //     ->setSeller($user);
            $em->persist($item);
            $em->flush();
            $this->addFlash('success', 'Your item has been put on sale');

            return $this->redirectToRoute('user-profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
    }



    #[Route('/user/profil/{id}/edit', name: 'user-edit', methods: ['GET', 'POST'])]
    public function editProfil(Users $user, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Your profile has been successfully updated');

            return $this->redirectToRoute('user-profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }
}