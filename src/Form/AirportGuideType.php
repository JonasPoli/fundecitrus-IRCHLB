<?php

namespace App\Form;

use App\Entity\AirportGuide;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportGuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome do Aeroporto'])
            ->add('code', null, [
                'label' => 'Código IATA (Ex: RAO)'])
            ->add('description', null, [
                'label' => 'Informações / Guia de Transfer'])
            ->add('distance', null, [
                'label' => 'Distância até o Evento (Ex: 10 km)'])
            ->add('transport', null, [
                'label' => 'Opções de Transporte Recomendadas'])
            ->add('position', HiddenType::class)
            ->add('image', ImageType::class, [
                'label' => 'Imagem do Aeroporto',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AirportGuide::class,
        ]);
    }
}
