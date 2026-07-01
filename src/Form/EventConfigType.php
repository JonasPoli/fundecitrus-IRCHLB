<?php

namespace App\Form;

use App\Entity\EventConfig;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locationName', null, [
                'label' => 'Nome do Local'])
            ->add('addressStreet', null, [
                'label' => 'Rua / Endereço'])
            ->add('addressNeighborhood', null, [
                'label' => 'Bairro'])
            ->add('addressCity', null, [
                'label' => 'Cidade'])
            ->add('addressZipCode', null, [
                'label' => 'CEP'])
            ->add('googleMapsUrl', null, [
                'label' => 'Link de Localização do Google Maps'])
            ->add('supportEmail', null, [
                'label' => 'E-mail de Suporte'])
            ->add('supportPhone', null, [
                'label' => 'Telefone de Suporte'])
            ->add('whatsappNumber', null, [
                'label' => 'Número do WhatsApp'])
            ->add('linkedinUrl', null, [
                'label' => 'Link do LinkedIn'])
            ->add('instagramUrl', null, [
                'label' => 'Link do Instagram'])
            ->add('youtubeUrl', null, [
                'label' => 'Link do YouTube'])
            ->add('prospectusFile', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'id',
                'label' => 'Arquivo do Edital / Prospecto (PDF)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventConfig::class,
        ]);
    }
}
