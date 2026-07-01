<?php

namespace App\Form;

use App\Entity\RegistrationBatch;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationBatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Batch Name (e.g. 1st Batch)'])
            ->add('startDate', null, [
                'label' => 'Start Date',
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'label' => 'End Date / Deadline',
                'widget' => 'single_text',
            ])
            ->add('position', HiddenType::class)
            ->add('price', null, [
                'label' => 'Price / Value'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationBatch::class,
        ]);
    }
}
