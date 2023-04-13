<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



class BlogPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }

    public function createEntity(string $entityFqcn) {
        $blogPost = new BlogPost();
        $blogPost->setCreatedAt(new DateTime());

        return $blogPost;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setFormTypeOptions(['required' => false])->hideOnForm(),
            TextField::new('title'),
            TextField::new('content'),
            'slug',
            AssociationField::new('author'),
            AssociationField::new('comments')->hideOnForm()->setTemplatePath('/bundles/EasyAdminBundle/comments.html.twig'),
            DateTimeField::new('createdAt', "Created")->setFormTypeOptions(['required' => false])->hideOnForm(),
            AssociationField::new('images')
        ];
    }
}
