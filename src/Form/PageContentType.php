<?php

namespace App\Form;

use App\Entity\PageContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug', null, [
                'label' => 'Identificador Slug (Ex: termos-de-uso)'])
            ->add('title', null, [
                'label' => 'Título da Página'])
            ->add('content', null, [
                'label' => 'Conteúdo da Página (Suporta HTML)'])
            ->add('updatedAt', null, [
                'label' => 'Última Atualização',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageContent::class,
        ]);
    }
}
