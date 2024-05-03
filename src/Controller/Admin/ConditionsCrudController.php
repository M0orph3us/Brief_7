<?php

namespace App\Controller\Admin;

use App\Entity\Conditions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConditionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conditions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('status'),
        ];
    }
}