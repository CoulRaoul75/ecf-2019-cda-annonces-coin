<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File as AssertFile;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre de ton annonce', 'help'=>'80 caractères max.'] )
            ->add('text', TextareaType::class, ['label' => 'Texte de ton annonce', 'help'=>'200 caractères max. De quoi faire une belle annonce.', 'attr' => ['rows'=>'4']])
            ->add('category', EntityType::class, ['label' => 'Catégorie', 'help'=>'Choisis ta catégorie dans le menu.' , 'class' => Category::class,
                'choice_label' => 'titleCategory',
                'multiple' => false,
                'expanded' => false])
            ->add('createdAt', DateType::class, ['label' => 'Date de publication', 'widget' => "single_text"])
            ->add('photoInput', FileType::class,[
                'label' => 'Télécharge 1 photo',
                'help' => 'Fais une belle photo pour augmenter tes chances.',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new AssertFile([
                        'maxSize'=> '1024k',
                        'mimeTypes' => ['image/png', 'image/jpg','image/gif'],
                        'maxSizeMessage' => "Taille maximum de l'image: 5Mo",
                        'mimeTypesMessage' => "Seuls les fichiers images sont autorisés"
                    ])
                ]
            ])
            ->add('price', TextType::class, ['label' => 'Prix', 'help' => 'Entre 0 € et 99 999 €'])

            ->add('submit', SubmitType::class, ['label'=>'Publie ton annonce', 'attr' => ['class' => 'btn btn-block btn-danger']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
