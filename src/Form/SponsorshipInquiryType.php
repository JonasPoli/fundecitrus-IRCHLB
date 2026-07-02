<?php

namespace App\Form;

use App\Entity\SponsorshipInquiry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorshipInquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', null, [
                'label' => 'Nome da Empresa'])
            ->add('contactPerson', null, [
                'label' => 'Nome do Contato'])
            ->add('corporateEmail', null, [
                'label' => 'E-mail Corporativo'])
            ->add('interestArea', null, [
                'label' => 'Área de Interesse (Cota de Patrocínio)'])
            ->add('createdAt', null, [
                'label' => 'Enviado Em',
                'widget' => 'single_text',
            ])
            ->add('status', null, [
                'label' => 'Status da Resposta'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorshipInquiry::class,
        ]);
    }
}
