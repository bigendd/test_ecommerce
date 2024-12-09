<?php

namespace App\Form;

use App\Entity\Apartments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApartmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('price')
            ->add('maxGuests')
            ->add('isAvailable')
            ->add('availableFrom', null, [
                'widget' => 'single_text',
            ])
            ->add('availableUntil', null, [
                'widget' => 'single_text',
            ])
            ->add('type')
            ->add('description', TextareaType::class)
            ->add('images', FileType::class, [
                'label' => 'Images (fichiers multiples autorisés)',
                'multiple' => true,  // Permet le téléchargement de plusieurs fichiers
                'mapped' => false,   // Ne lie pas directement au champ d'entité (les images seront traitées séparément)
                'required' => false, // Les images ne sont pas obligatoires
                'attr' => [
                    'accept' => 'image/*', // Permet uniquement les images
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartments::class,
        ]);
    }
}
