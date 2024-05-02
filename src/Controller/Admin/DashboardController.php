<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Conditions;
use App\Entity\Subcategories;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
        } else {
            $this->addFlash('error', 'You do not have permission to access this page');
            return $this->redirectToRoute('app_home');
        }
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Board');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to site', 'fas fa-arrow-left', 'app_home');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Users::class);

        yield MenuItem::section('Categories');
        yield MenuItem::linkToCrud('Categories', 'fa-solid fa-list', Categories::class);

        yield MenuItem::section('Subcategories');
        yield MenuItem::linkToCrud('Subcategories', 'fa-solid fa-list', Subcategories::class);

        yield MenuItem::section('Conditions');
        yield MenuItem::linkToCrud('Conditions', 'fa-solid fa-list', Conditions::class);
    }
}