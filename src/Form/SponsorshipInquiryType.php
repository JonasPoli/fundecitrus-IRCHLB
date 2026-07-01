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
                'label' => 'Company Name'])
            ->add('contactPerson', null, [
                'label' => 'Contact Person Name'])
            ->add('corporateEmail', null, [
                'label' => 'Corporate E-mail'])
            ->add('interestArea', null, [
                'label' => 'Interest Area (e.g. Quota level)'])
            ->add('createdAt', null, [
                'label' => 'Inquiry Sent At',
                'widget' => 'single_text',
            ])
            ->add('status', null, [
                'label' => 'Status / Response State'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorshipInquiry::class,
        ]);
    }
}
