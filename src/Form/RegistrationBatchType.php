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
                'label' => 'Registration Category (e.g., Professional, Student, Invited Speaker, Accompanying Person)',
            ])
            ->add('periodText', null, [
                'label' => 'Registration Period (e.g., Early Bird* – Regular – Late)',
                'required' => false,
            ])
            ->add('hlbPrice', null, [
                'label' => 'HLB Congress Price (e.g., US$ 350 / 400 / 450 or Free)',
                'required' => false,
            ])
            ->add('iocvPrice', null, [
                'label' => 'IOCV Conference Price (e.g., US$ 100 / 150 / 200 or Free)',
                'required' => false,
            ])
            ->add('fullPrice', null, [
                'label' => 'Full Congress Price (HLB + IOCV) (e.g., US$ 400 / 450 / 500 or Free)',
                'required' => false,
            ])
            ->add('notes', null, [
                'label' => 'Special Restrictions / Notes',
                'required' => false,
                'attr' => ['rows' => 3],
            ])
            ->add('startDate', null, [
                'label' => 'Start Date (Optional)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDate', null, [
                'label' => 'End Date / Deadline (Optional)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('position', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationBatch::class,
        ]);
    }
}
