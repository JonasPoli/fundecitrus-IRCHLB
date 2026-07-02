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
                'label' => 'Nome'])
            ->add('lastName', null, [
                'label' => 'Sobrenome'])
            ->add('email', null, [
                'label' => 'E-mail'])
            ->add('subject', null, [
                'label' => 'Assunto'])
            ->add('message', null, [
                'label' => 'Mensagem'])
            ->add('consent', null, [
                'label' => 'Consentimento com Políticas de Privacidade'])
            ->add('createdAt', null, [
                'label' => 'Criado Em',
                'widget' => 'single_text',
            ])
            ->add('status', null, [
                'label' => 'Status da Resposta'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
