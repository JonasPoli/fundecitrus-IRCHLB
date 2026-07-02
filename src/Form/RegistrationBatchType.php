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
                'label' => 'Nome do Lote (Ex: 1º Lote)'])
            ->add('startDate', null, [
                'label' => 'Data de Início',
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'label' => 'Data de Término / Prazo',
                'widget' => 'single_text',
            ])
            ->add('position', HiddenType::class)
            ->add('price', null, [
                'label' => 'Preço / Valor'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationBatch::class,
        ]);
    }
}
