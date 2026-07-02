<?php

namespace App\Form;

use App\Entity\ThematicGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThematicGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Título'])
            ->add('description', null, [
                'label' => 'Descrição'])
            ->add('eventDate', null, [
                'label' => 'Data do Evento',
                'widget' => 'single_text',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ThematicGroup::class,
        ]);
    }
}
