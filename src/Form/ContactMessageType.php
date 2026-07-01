<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => 'First Name'])
            ->add('lastName', null, [
                'label' => 'Last Name'])
            ->add('email', null, [
                'label' => 'E-mail'])
            ->add('subject', null, [
                'label' => 'Subject'])
            ->add('message', null, [
                'label' => 'Message'])
            ->add('consent', null, [
                'label' => 'Consent to Data Privacy Regulations'])
            ->add('createdAt', null, [
                'label' => 'Created At',
                'widget' => 'single_text',
            ])
            ->add('status', null, [
                'label' => 'Status / Response State'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
