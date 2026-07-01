<?php

namespace App\Form;

use App\Entity\AgendaActivity;
use App\Entity\EventDay;
use App\Entity\Speaker;
use App\Entity\VenueRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Título da Atividade'])
            ->add('type', null, [
                'label' => 'Tipo (Ex: Palestra, Mesa Redonda, Coffee Break)'])
            ->add('startTime', null, [
                'label' => 'Horário de Início',
                'widget' => 'single_text',
            ])
            ->add('endTime', null, [
                'label' => 'Horário de Término',
                'widget' => 'single_text',
            ])
            ->add('description', null, [
                'label' => 'Descrição / Ementa'])
            ->add('eventDay', EntityType::class, [
                'class' => EventDay::class,
                'choice_label' => 'title',
                'label' => 'Dia do Evento',
            ])
            ->add('room', EntityType::class, [
                'class' => VenueRoom::class,
                'choice_label' => 'name',
                'label' => 'Sala / Auditório',
                'required' => false,
            ])
            ->add('speakers', EntityType::class, [
                'class' => Speaker::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Palestrantes',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgendaActivity::class,
        ]);
    }
}
