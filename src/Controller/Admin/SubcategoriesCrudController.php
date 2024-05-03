<?php

namespace App\Controller\Admin;

use App\Entity\Subcategories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubcategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subcategories::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('subcategory'),
        ];
    }
}