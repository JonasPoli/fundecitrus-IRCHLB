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
                'label' => 'Nome do Patrocinador'])
            ->add('websiteUrl', null, [
                'label' => 'URL do Site'])
            ->add('description', null, [
                'label' => 'Descrição'])
            ->add('standNumber', null, [
                'label' => 'Número do Estande / Área'])
            ->add('isExhibitor', null, [
                'label' => 'É Expositor?'])
            ->add('position', HiddenType::class)
            ->add('logo', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'id',
                'label' => 'Logotipo (Imagem)',
            ])
            ->add('tier', EntityType::class, [
                'class' => SponsorshipTier::class,
                'choice_label' => 'name',
                'label' => 'Categoria de Patrocínio',
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
