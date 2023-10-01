<?php

namespace App\Form\Type;
use App\Entity\Gecko;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeckoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Samiec' => 'samiec',
                    'Samica' => 'samica'
                ]
            ])
            ->add('price', IntegerType::class)
            ->add('geckType', ChoiceType::class, [
                'choices' => [
                    'Lamparci' => 1,
                    'Gruboogonowy' => 2,
                    'Kaledonia' => 3,
                ]
            ])
            ->add('file', FileType::class, [
                'label' => 'label.file',
                'required' => false
            ])
            ->add('breedingNumber', TextType::class, [
                'required' => false
            ])
            ->add('reserved', HiddenType::class, [
                'data' => false
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gecko::class,
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}