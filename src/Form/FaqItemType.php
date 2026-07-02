<?php

namespace App\Form;

use App\Entity\FaqCategory;
use App\Entity\FaqItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', null, [
                'label' => 'Pergunta'])
            ->add('answer', null, [
                'label' => 'Resposta'])
            ->add('position', HiddenType::class)
            ->add('isActive', null, [
                'label' => 'Está Ativo?'])
            ->add('category', EntityType::class, [
                'class' => FaqCategory::class,
                'choice_label' => 'name',
                'label' => 'Categoria de FAQ',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FaqItem::class,
        ]);
    }
}
