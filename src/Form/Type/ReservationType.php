<?php

namespace App\Form\Type;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;


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
            ->add("username", TextType::class, [
                'label' => "Nazwa użytkownika*"
            ])
            ->add("email", EmailType::class,[
                "label" => "Email*"
            ])
            ->add("retypedEmail", EmailType::class,[
                "label" => "Powtórz email*"
            ])
            ->add("phoneNumber", TelType::class, [
                'label' => "Numer telefonu (opcjonalne)",
                'required' => false
            ])
            ->add("agreeTerms", CheckboxType::class, [
                'label' => "Akceptuję regulamin hodowlii",
                'mapped' => false
            ])
            ->add("message", TextareaType::class, [
                'label' => "Wiadomość* (prosimy podać propozycję odbioru zwierząt - odbiór w Poznaniu/na giełdzie/inne)"
            ])
            // ->add('captcha', Recaptcha3Type::class, [
            //     'constraints' => new Recaptcha3(),
            //     'action_name' => 'homepage',
            //     'locale' => 'pl',
            // ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['style' => 'background-color:#ff5722;border-none;',
                           'class' => 'w-50' 
                ]
            ]);

    }

}