<?php

namespace App\Controller\Admin;

use App\Entity\Gecko;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GeckoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gecko::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
