<?php

namespace App\Form;

use App\Entity\RestaurantRecommendation;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantRecommendationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome do Restaurante'])
            ->add('priceRange', null, [
                'label' => 'Faixa de Preço (Ex: $$, $$$)'])
            ->add('category', null, [
                'label' => 'Categoria / Especialidade Gastronômica'])
            ->add('description', null, [
                'label' => 'Descrição / Avaliação'])
            ->add('locationUrl', null, [
                'label' => 'Link de Localização do Google Maps'])
            ->add('position', HiddenType::class)
            ->add('image', ImageType::class, [
                'label' => 'Imagem do Restaurante / Prato',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RestaurantRecommendation::class,
        ]);
    }
}
