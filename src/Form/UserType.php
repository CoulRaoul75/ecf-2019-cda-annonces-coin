<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label'=>'Ton prénom'])
            ->add('name', TextType::class, ['label' => 'Ton nom'] )
            ->add('address',TextType::class, ['label' => 'Ton adresse'] )
            ->add('postalCode', TextType::class, ['label' => 'Ton code postal'] )
            ->add('city', TextType::class, ['label' => 'Ta ville'] )
            ->add('phone', TextType::class, ['label' => 'Ton numéro de téléphone'] )
            ->add('email', TextType::class, ['label' => 'Ton email', 'help' => 'Ce sera aussi ton identifiant pour te connecter'] )
            ->add('password', TextType::class, ['label' => 'Ton mot de passe'])

            ->add('submit', SubmitType::class, ["label" => "Enregistre ton compte", "attr" => ["class" => "btn btn-danger btn-block"] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
