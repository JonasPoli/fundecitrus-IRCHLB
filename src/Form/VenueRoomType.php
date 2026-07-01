<?php

namespace App\Form;

use App\Entity\VenueRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenueRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome da Sala / Auditório'])
            ->add('capacity', null, [
                'label' => 'Capacidade Máxima (Pessoas)'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VenueRoom::class,
        ]);
    }
}
