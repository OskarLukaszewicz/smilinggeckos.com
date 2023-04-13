<?php

namespace App\Controller\Admin;

use App\Entity\Gecko;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Vich\UploaderBundle\Form\Type\VichFileType;

class GeckoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gecko::class;
    }

    public function createEntity(string $entityFqcn) {
        $gecko = new Gecko();
        $gecko->setReserved(false);
        $gecko->setCreatedAt(new DateTime());

        return $gecko;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setFormTypeOptions(['required' => false]),
            BooleanField::new('reserved')->hideOnForm(),
            "name",
            ChoiceField::new('sex')->setChoices(
                [
                    'male' => 'samiec',
                    'female' => 'samica'
                ]
            ),
            'price',
            TextField::new('geckType', 'Species'),
            ChoiceField::new('geckType')->setChoices(
                [
                    'Lamparci' => 1,
                    'Gruboogonowy' => 2,
                    'Nowa Kaledonia' => 3
                ]
            )->onlyOnForms(),
            DateTimeField::new('createdAt')->setFormTypeOptions(['required' => false])->hideOnForm(),
            TextareaField::new('file')->setFormType(VichFileType::class)->onlyOnForms(),
            ImageField::new('filename', 'Image')->setBasePath('images/')->setUploadDir('public/images/')->hideOnForm(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('sex')
                ->setChoices([
                    "samica" => "samica", 
                    "samiec" => "samiec", 
                ]))

            ->add(ChoiceFilter::new('geckType')
                ->setChoices([
                    "Lamparcie" => 1, 
                    "Gruboogonowe" => 2, 
                    "Nowa Kaledonia" => 3
                ])
            );
    }
    
}
