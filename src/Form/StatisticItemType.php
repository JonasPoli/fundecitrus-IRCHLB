<?php

namespace App\Form;

use App\Entity\StatisticItem;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatisticItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [
                'label' => 'Rótulo / Descrição'])
            ->add('value', null, [
                'label' => 'Valor (Ex: 500+, 25+)'])
            ->add('position', HiddenType::class)
            ->add('isActive', null, [
                'label' => 'Está Ativo?'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatisticItem::class,
        ]);
    }
}
