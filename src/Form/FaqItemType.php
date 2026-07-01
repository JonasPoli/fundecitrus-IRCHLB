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
                'label' => 'Question'])
            ->add('answer', null, [
                'label' => 'Answer'])
            ->add('position', HiddenType::class)
            ->add('isActive', null, [
                'label' => 'Is Active?'])
            ->add('category', EntityType::class, [
                'class' => FaqCategory::class,
                'choice_label' => 'name',
                'label' => 'Category',
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
