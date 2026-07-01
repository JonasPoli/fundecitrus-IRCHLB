<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Sponsor;
use App\Entity\SponsorshipTier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Sponsor Name'])
            ->add('websiteUrl', null, [
                'label' => 'Website URL'])
            ->add('description', null, [
                'label' => 'Description'])
            ->add('standNumber', null, [
                'label' => 'Stand Number / Area'])
            ->add('isExhibitor', null, [
                'label' => 'Is Exhibitor?'])
            ->add('position', HiddenType::class)
            ->add('logo', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'id',
                'label' => 'Logo Image',
            ])
            ->add('tier', EntityType::class, [
                'class' => SponsorshipTier::class,
                'choice_label' => 'name',
                'label' => 'Sponsorship Tier',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
