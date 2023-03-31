<?php

namespace App\Form\Type;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'gecko' => null,
            'data_class' => Reservation::class,
        ]);
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("accepted", HiddenType::class, [
                'empty_data' => false
            ])
            ->add("email", EmailType::class,[
                "label" => "Adres e-mail*"
            ])
            ->add("phoneNumber", TelType::class, [
                'label' => "Number telefonu (opcjonalne)"
            ])
            ->add("message", TextType::class, [
                'label' => "Wiadomość*"
            ])
            ->add('submit', SubmitType::class);

            
            // ->add("gecks", CollectionType::class, [
            //     "label" => "Rezerwowane gekony",
            //     'entry_type' => ChoiceType::class,
            //     'entry_options' => [
            //         'choices' => [
            //             'Gekon' => "eeeeMakarena",
            //             'Gekoni' => "eeeeMakarenaa",
            //             'Gekono' => "eeeeMakarenyy", 
            //         ]
            //     ]
            // ]);
            
    }
    // 'Gekoni' => $options['gecko'],

}