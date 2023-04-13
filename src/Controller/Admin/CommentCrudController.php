<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function createEntity(string $entityFqcn) {
        $comment = new Comment();
        $comment->setCreatedAt(new DateTime());

        return $comment;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setFormTypeOptions(['required' => false]),
            TextField::new('authorName', 'Author'),
            TextField::new('content', 'Content'),
            AssociationField::new('blogPost', 'Post'),
            DateTimeField::new('createdAt', 'Created')->hideOnForm()
        ];
    }

}
