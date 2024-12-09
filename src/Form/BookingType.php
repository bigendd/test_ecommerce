<?php

namespace App\Form;

use App\Entity\Apartments;
use App\Entity\Booking;
use App\Entity\Rooms;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('totalAmount')
            ->add('userEntity', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('appartements', EntityType::class, [
                'class' => Apartments::class,
                'choice_label' => 'id',
            ])
            ->add('rooms', EntityType::class, [
                'class' => Rooms::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
