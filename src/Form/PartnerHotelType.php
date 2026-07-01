<?php

namespace App\Form;

use App\Entity\PartnerHotel;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerHotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome do Hotel'])
            ->add('stars', null, [
                'label' => 'Classificação (Estrelas 1-5)'])
            ->add('description', null, [
                'label' => 'Descrição'])
            ->add('bookingCode', null, [
                'label' => 'Código de Desconto para Reserva'])
            ->add('bookingLink', null, [
                'label' => 'Link Direto para Reserva'])
            ->add('address', null, [
                'label' => 'Endereço'])
            ->add('contact', null, [
                'label' => 'Telefone / Informações de Contato'])
            ->add('position', HiddenType::class)
            ->add('image', ImageType::class, [
                'label' => 'Imagem do Hotel',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PartnerHotel::class,
        ]);
    }
}
